<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  System.Grayscale
 * @version     1.8.0
 * @author      Pisan Chueachatchai
 * @copyright   (C) 2025 Colorpack Creations Co.,Ltd.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @link        https://www.Colorpack.co.th
 * @description Convert site to grayscale with black bar, ribbon, image, text, and Thai Google Fonts support.
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Filesystem\Path;

class PlgSystemGrayscale extends CMSPlugin
{
    protected $app;
    
    /**
     * CSS class prefix เพื่อหลีกเลี่ยงการชนกับ CSS อื่น
     */
    protected $cssPrefix = 'gs-';

    /**
     * Load CSS and JS for admin
     */
    public function onAfterDispatch()
    {
        if (!$this->app->isClient('administrator')) {
            return;
        }

        $view = $this->app->input->get('view');
        $option = $this->app->input->get('option');

        // Load only on plugin configuration page
        if ($option === 'com_plugins' && $view === 'plugin' && $this->app->input->get('extension_id')) {
            $document = $this->app->getDocument();
            
            // Add CSS
            $document->addStyleSheet(Uri::root(true) . '/media/plg_system_grayscale/css/admin.css');
            
            // Add JS
            $document->addScript(Uri::root(true) . '/media/plg_system_grayscale/js/admin.js');
        }
    }

    public function onAfterRender()
    {
        if ($this->app->isClient('administrator')) {
            return;
        }

        try {
            // ดึงและ sanitize parameters
            $params = $this->getSanitizedParams();
            
            // สร้าง CSS และ HTML
            $css = $this->generateCSS($params);
            $html = $this->generateHTML($params);
            
            // แทรก CSS และ HTML ลงในหน้าเว็บ
            $this->injectContent($css, $html);
            
        } catch (Exception $e) {
            // Log error แต่ไม่แสดงให้ user เห็น
            $this->logError($e->getMessage());
        }
    }

    /**
     * ดึงและ sanitize parameters ทั้งหมด
     */
    protected function getSanitizedParams()
    {
        return [
            'intensity'       => (int) $this->params->get('intensity', 80),
            'excludeMedia'    => (int) $this->params->get('exclude_media', 1),
            'barEnabled'      => (int) $this->params->get('bar_enabled', 0),
            'barPosition'     => $this->sanitizeString($this->params->get('bar_position', 'top')),
            'barColor'        => $this->sanitizeColorName($this->params->get('bar_color', 'dam-khe-ma')),
            'barImage'        => $this->sanitizePath($this->params->get('bar_image', '')),
            'barImgWidth'     => $this->sanitizeCssValue($this->params->get('bar_image_width', '100px')),
            'barHeight'       => $this->sanitizeCssValue($this->params->get('bar_height', '50px')),
            'barText'         => $this->sanitizeString($this->params->get('bar_text', 'น้อมสำนึกในพระมหากรุณาธิคุณเป็นล้นพ้นอันหาที่สุดมิได้')),
            'barFont'         => $this->sanitizeFontName($this->params->get('bar_font', 'Charm')),
            'ribbonEnabled'   => (int) $this->params->get('ribbon_enabled', 0),
            'ribbonPosition'  => $this->sanitizeString($this->params->get('ribbon_position', 'top-left')),
            'ribbonImage'     => $this->sanitizePath($this->params->get('ribbon_image', ''))
        ];
    }

    /**
     * Sanitize string input
     */
    protected function sanitizeString($value)
    {
        return htmlspecialchars(strip_tags($value), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Sanitize file path
     */
    protected function sanitizePath($path)
    {
        if (empty($path)) {
            return '';
        }
        
        // ลบ dangerous characters
        $path = preg_replace('/[^a-zA-Z0-9_\-\.\/]/', '', $path);
        
        return $path;
    }

    /**
     * Sanitize CSS value (ป้องกัน CSS injection)
     */
    protected function sanitizeCssValue($value)
    {
        // อนุญาตเฉพาะตัวเลข, ตัวอักษร, %, px, em, rem, vw, vh
        if (preg_match('/^[\d\.\s]+(px|em|rem|%|vw|vh)$/i', $value)) {
            return htmlspecialchars($value, ENT_QUOTES);
        }
        
        return '50px'; // default value
    }

    /**
     * Sanitize font name (ป้องกัน XSS)
     */
    protected function sanitizeFontName($fontName)
    {
        // อนุญาตเฉพาะตัวอักษร, ตัวเลข, ช่องว่าง, และ +
        $fontName = preg_replace('/[^a-zA-Z0-9\s\+]/', '', $fontName);
        return trim($fontName);
    }

    /**
     * Sanitize color name (ป้องกัน XSS)
     */
    protected function sanitizeColorName($colorName)
    {
        // อนุญาตเฉพาะตัวอักษร, ตัวเลข, และ -
        $colorName = preg_replace('/[^a-zA-Z0-9\-]/', '', $colorName);
        $colorName = strtolower(trim($colorName));
        
        // ตรวจสอบว่ามีในรายการสีที่อนุญาต (Sukkaphap Collection)
        $allowedColors = [
            'dam-khe-ma', 'tao', 'phan-khram', 'khab-dam', 'nil-kan',
            'muek-jin', 'khe-ma-yang', 'peek-ka', 'dam-muek', 'khiew-nil',
            'look-wa', 'namtan-mai', 'som-rit-dech', 'lek-lai', 'mo-muek',
            'sawat', 'nam-rak', 'som-rit', 'kaki', 'tao-khieow',
            'dok-lao', 'bua-roi', 'khwan-phloeng', 'mok', 'khao-khab'
        ];
        
        return in_array($colorName, $allowedColors) ? $colorName : 'dam-khe-ma';
    }

    /**
     * สร้าง CSS
     */
    protected function generateCSS($params)
    {
        $intensity = max(0, min(100, $params['intensity'])); // คลุม 0-100
        $barFont = $params['barFont'];
        
        $fontUrl = $this->getGoogleFontUrl($barFont);
        
        $barClass = $this->cssPrefix . 'bar';
        $ribbonClass = $this->cssPrefix . 'ribbon';
        $wrapperClass = $this->cssPrefix . 'bar-wrapper';
        
        $css = '<link href="' . htmlspecialchars($fontUrl, ENT_QUOTES) . '" rel="stylesheet" crossorigin="anonymous">';
        $css .= "\n<style id=\"" . $this->cssPrefix . "styles\">\n";
        
        // Use gray overlay with mix-blend-mode (allows exceptions!)
        $css .= "    body::before {\n";
        $css .= "        content: '';\n";
        $css .= "        position: fixed;\n";
        $css .= "        top: 0;\n";
        $css .= "        left: 0;\n";
        $css .= "        width: 100%;\n";
        $css .= "        height: 100%;\n";
        // Intensity directly controls opacity: 0% = transparent, 100% = full grayscale
        $opacity = $intensity / 100;
        $css .= "        background: gray;\n";
        $css .= "        opacity: {$opacity};\n";
        $css .= "        mix-blend-mode: saturation;\n";
        $css .= "        pointer-events: none;\n";
        $css .= "        z-index: 99998;\n";
        $css .= "    }\n\n";
        
        // Exclude bar wrapper
        $css .= "    .{$wrapperClass} {\n";
        $css .= "        position: relative;\n";
        $css .= "        z-index: 99999;\n";
        $css .= "        mix-blend-mode: normal !important;\n";
        $css .= "    }\n\n";
        
        // Conditionally exclude media
        if ($params['excludeMedia']) {
            $css .= "    img, video, iframe, object, embed, canvas, svg, picture, source {\n";
            $css .= "        position: relative;\n";
            $css .= "        z-index: 99999;\n";
            $css .= "        mix-blend-mode: normal !important;\n";
            $css .= "    }\n\n";
        }
        
        // Black bar styles - with ThaiTone color class
        $css .= "    .{$barClass} {\n";
        $css .= "        width: 100vw;\n";
        $css .= "        height: {$params['barHeight']};\n";
        $css .= "        text-align: center;\n";
        $css .= "        font-family: \"{$barFont}\", sans-serif;\n";
        $css .= "        display: flex;\n";
        $css .= "        justify-content: center;\n";
        $css .= "        align-items: center;\n";
        $css .= "        gap: 10px;\n";
        $css .= "        z-index: 99999;\n";
        $css .= "        position: relative;\n";
        $css .= "        overflow: hidden;\n";
        $css .= "        box-sizing: border-box;\n";
        $css .= "    }\n";
        $css .= "    .{$barClass} img {\n";
        $css .= "        max-width: {$params['barImgWidth']};\n";
        $css .= "        height: auto;\n";
        $css .= "        display: inline-block;\n";
        $css .= "    }\n";
        $css .= "    .{$barClass} span {\n";
        $css .= "        display: inline-block;\n";
        $css .= "        font-size: calc({$params['barHeight']} / 2.5);\n";
        $css .= "        line-height: 1.2;\n";
        $css .= "    }\n\n";
        
        // ThaiTone Color Classes
        $css .= $this->getThaiToneColorCSS($barClass);
        
        // Ribbon styles
        $css .= "    .{$ribbonClass} {\n";
        $css .= "        position: fixed;\n";
        $css .= "        z-index: 999999;\n";
        $css .= "        width: 70px;\n";
        $css .= "        height: auto;\n";
        $css .= "        pointer-events: none;\n";
        $css .= "    }\n";
        
        // Ribbon position classes
        $css .= "    .{$ribbonClass}." . $this->cssPrefix . "top { top: 0; }\n";
        $css .= "    .{$ribbonClass}." . $this->cssPrefix . "bottom { bottom: 0; }\n";
        $css .= "    .{$ribbonClass}." . $this->cssPrefix . "left { left: 0; }\n";
        $css .= "    .{$ribbonClass}." . $this->cssPrefix . "right { right: 0; }\n";
        
        // Responsive
        $css .= "\n    @media only all and (min-width: 768px) {\n";
        $css .= "        .{$ribbonClass} { width: auto; }\n";
        $css .= "    }\n";
        
        $css .= "</style>\n";
        
        return $css;
    }

    /**
     * สร้าง Google Font URL
     */
    protected function getGoogleFontUrl($fontName)
    {
        $fontUrl = str_replace(' ', '+', $fontName);
        return "https://fonts.googleapis.com/css2?family={$fontUrl}&display=swap";
    }

    /**
     * สร้าง CSS สำหรับ ThaiTone Colors (Sukkaphap Collection)
     */
    protected function getThaiToneColorCSS($barClass)
    {
        $css = "    /* ThaiTone – Sukkaphap Collection (25 Colors) */\n";
        
        $css .= "    .{$barClass}.dam-khe-ma { background: #00040A !important; color: #fff !important; }\n";
        $css .= "    .{$barClass}.tao { background: #7C7C7C !important; color: #fff !important; }\n";
        $css .= "    .{$barClass}.phan-khram { background: #364F5A !important; color: #fff !important; }\n";
        $css .= "    .{$barClass}.khab-dam { background: #162836 !important; color: #fff !important; }\n";
        $css .= "    .{$barClass}.nil-kan { background: #051520 !important; color: #fff !important; }\n";
        $css .= "    .{$barClass}.muek-jin { background: #494C54 !important; color: #fff !important; }\n";
        $css .= "    .{$barClass}.khe-ma-yang { background: #6D6C67 !important; color: #fff !important; }\n";
        $css .= "    .{$barClass}.peek-ka { background: #2A2D29 !important; color: #fff !important; }\n";
        $css .= "    .{$barClass}.dam-muek { background: #444547 !important; color: #fff !important; }\n";
        $css .= "    .{$barClass}.khiew-nil { background: #112B37 !important; color: #fff !important; }\n";
        $css .= "    .{$barClass}.look-wa { background: #5A3E4C !important; color: #fff !important; }\n";
        $css .= "    .{$barClass}.namtan-mai { background: #55383A !important; color: #fff !important; }\n";
        $css .= "    .{$barClass}.som-rit-dech { background: #685B4B !important; color: #fff !important; }\n";
        $css .= "    .{$barClass}.lek-lai { background: #4C3F2B !important; color: #fff !important; }\n";
        $css .= "    .{$barClass}.mo-muek { background: #5E6665 !important; color: #fff !important; }\n";
        $css .= "    .{$barClass}.sawat { background: #918F95 !important; color: #fff !important; }\n";
        $css .= "    .{$barClass}.nam-rak { background: #4B2F2D !important; color: #fff !important; }\n";
        $css .= "    .{$barClass}.som-rit { background: #8A7358 !important; color: #fff !important; }\n";
        $css .= "    .{$barClass}.kaki { background: #BBA88E !important; color: #000 !important; }\n";
        $css .= "    .{$barClass}.tao-khieow { background: #BEC8BD !important; color: #000 !important; }\n";
        $css .= "    .{$barClass}.dok-lao { background: #C5C1C6 !important; color: #000 !important; }\n";
        $css .= "    .{$barClass}.bua-roi { background: #9A8F8C !important; color: #fff !important; }\n";
        $css .= "    .{$barClass}.khwan-phloeng { background: #AFA094 !important; color: #000 !important; }\n";
        $css .= "    .{$barClass}.mok { background: #D5D3C2 !important; color: #000 !important; }\n";
        $css .= "    .{$barClass}.khao-khab { background: #E3E5DF !important; color: #000 !important; }\n\n";
        
        return $css;
    }

    /**
     * สร้าง HTML content
     */
    protected function generateHTML($params)
    {
        $html = [];
        
        // สร้าง bar HTML
        if ($params['barEnabled']) {
            $html['bar'] = $this->generateBarHTML($params);
        }
        
        // สร้าง ribbon HTML
        if ($params['ribbonEnabled']) {
            $html['ribbon'] = $this->generateRibbonHTML($params);
        }
        
        return $html;
    }

    /**
     * สร้าง bar HTML
     */
    protected function generateBarHTML($params)
    {
        $barClass = $this->cssPrefix . 'bar';
        $barColor = $params['barColor'];
        
        $imgHTML = '';
        if (!empty($params['barImage'])) {
            $imgSrc = Uri::root() . ltrim($params['barImage'], '/');
            $imgHTML = '<img src="' . htmlspecialchars($imgSrc, ENT_QUOTES) . '" alt="Bar Image">';
        }
        
        $textHTML = '';
        if (!empty($params['barText'])) {
            $textHTML = '<span>' . htmlspecialchars($params['barText'], ENT_QUOTES, 'UTF-8') . '</span>';
        }
        
        if (empty($imgHTML) && empty($textHTML)) {
            return ''; // ไม่มีอะไรให้แสดง
        }
        
        // เพิ่ม class สี ThaiTone
        $classes = $barClass . ' ' . htmlspecialchars($barColor, ENT_QUOTES);
        
        return '<div class="' . $classes . '">' . $imgHTML . $textHTML . '</div>';
    }

    /**
     * สร้าง ribbon HTML
     */
    protected function generateRibbonHTML($params)
    {
        $ribbonClass = $this->cssPrefix . 'ribbon';
        
        // หา ribbon image source
        $ribbonSrc = $this->getRibbonImageSrc($params['ribbonImage'], $params['ribbonPosition']);
        
        // สร้าง position classes
        $positionClasses = $this->getRibbonPositionClasses($params['ribbonPosition']);
        
        $classes = $ribbonClass . ' ' . implode(' ', $positionClasses);
        
        return '<img src="' . htmlspecialchars($ribbonSrc, ENT_QUOTES) . '" alt="Ribbon" class="' . $classes . '" loading="lazy">';
    }

    /**
     * หา ribbon image source
     */
    protected function getRibbonImageSrc($customImage, $position)
    {
        if (!empty($customImage)) {
            return Uri::root() . ltrim($customImage, '/');
        }
        
        // ใช้รูปจากแพ็กเกจ (ในโฟลเดอร์ media/images)
                $ribbonFiles = [
            'top-left'     => 'black_ribbon_top_left.png',
            'top-right'    => 'black_ribbon_top_right.png',
                    'bottom-right' => 'black_ribbon_bottom_right.png',
            'bottom-left'  => 'black_ribbon_bottom_left.png'
        ];
        
        $filename = isset($ribbonFiles[$position]) ? $ribbonFiles[$position] : $ribbonFiles['top-left'];
        
        return Uri::root(true) . '/media/plg_system_grayscale/images/' . $filename;
    }

    /**
     * สร้าง position classes สำหรับ ribbon
     */
    protected function getRibbonPositionClasses($position)
    {
        $positions = [
            'top-left'     => [$this->cssPrefix . 'top', $this->cssPrefix . 'left'],
            'top-right'    => [$this->cssPrefix . 'top', $this->cssPrefix . 'right'],
            'bottom-right' => [$this->cssPrefix . 'bottom', $this->cssPrefix . 'right'],
            'bottom-left'  => [$this->cssPrefix . 'bottom', $this->cssPrefix . 'left']
        ];
        
        return isset($positions[$position]) ? $positions[$position] : $positions['top-left'];
    }

    /**
     * แทรก CSS และ HTML ลงในหน้าเว็บ
     */
    protected function injectContent($css, $html)
    {
        if (method_exists($this->app, 'getBody')) {
            $body = $this->app->getBody();
        } else {
            $body = JResponse::getBody();
        }
        
        // แทรก bar HTML
        if (isset($html['bar']) && !empty($html['bar'])) {
            if (isset($html['bar']) && !empty($html['bar'])) {
                $body = $this->injectBarContent($body, $html['bar']);
            }
        }
        
        // แทรก ribbon HTML
        if (isset($html['ribbon']) && !empty($html['ribbon'])) {
            $body = str_ireplace('</body>', $html['ribbon'] . '</body>', $body);
        }
        
        // แทรก CSS
        $body = str_ireplace('</head>', $css . '</head>', $body);

        // อัพเดท body
        if (method_exists($this->app, 'setBody')) {
            $this->app->setBody($body);
        } else {
            JResponse::setBody($body);
        }
    }

    /**
     * แทรก bar content ตาม position
     */
    protected function injectBarContent($body, $barHTML)
    {
        // ถ้า barHTML ว่างเปล่าไม่ต้องทำอะไร
        if (empty($barHTML)) {
            return $body;
        }
        
        // Wrap bar in a container
        $wrapperClass = $this->cssPrefix . 'bar-wrapper';
        $barHTML = '<div class="' . $wrapperClass . '">' . $barHTML . '</div>';
        
        // ตอนนี้เฉพาะ top position ถูก implement
        // ถ้าในอนาคตมี position อื่นๆ สามารถเพิ่มได้ที่นี่
        return preg_replace('#<body([^>]*)>#i', '<body\1>' . $barHTML, $body, 1);
    }

    /**
     * Log error
     */
    protected function logError($message)
    {
        if (class_exists('\\Joomla\\CMS\\Log\\Log')) {
            \Joomla\CMS\Log\Log::add($message, \Joomla\CMS\Log\Log::ERROR, 'plg_system_grayscale');
        }
    }
}
