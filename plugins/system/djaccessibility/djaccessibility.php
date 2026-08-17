<?php
/**
 * @package DJ-Accessibility
 * @copyright Copyright (C) DJ-Extensions.com, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email artur.kaczmarek@design-joomla.eu
 */

defined('_JEXEC') or die;

define ('DJACC_DEBUG', false);
define ('DJACC_VERSION', '1.02');
define ('DJACC_PATH', __DIR__);

use Joomla\CMS\Plugin\CMSPlugin;
use YOOtheme\Application;
use function YOOtheme\app;

//helpers
require __DIR__ . '/helpers/helper.php';
if( file_exists(__DIR__ . '/helpers/pro.php') ) require __DIR__ . '/helpers/pro.php';

class plgSystemDjaccessibility extends CMSPlugin {
	public function onAfterInitialise() {

		// check if YOOtheme Pro is loaded
		define('DJACC_YOOTHEME', class_exists(Application::class, false));

		JLoader::registerNamespace('DJAccessibility', JPATH_ROOT . "/plugins/system/djaccessibility");

		$this->loadLanguage();

		if( DJACC_YOOTHEME ) {
			/* Load Needed Classes */
			require __DIR__ . '/module/src/ConfigListener.php';

			// bootstrap modules
			$app = Application::getInstance();
			$app->load(__DIR__ . '/module/bootstrap.php');
		}
	}

	function onBeforeCompileHead() {

		$app = JFactory::getApplication();

		if ( $app->isClient('administrator') ) {
			return;
		}

		$doc = JFactory::getDocument();

		$min = ( DJACC_DEBUG ) ? '' : '.min';
		$ver = ( DJACC_DEBUG ) ? DJACC_VERSION . '-' . time() : DJACC_VERSION;

		$doc->addStyleSheet(JURI::root(true).'/plugins/system/djaccessibility/module/assets/css/accessibility.css', array('version' => $ver));
		$doc->addScript(JURI::root(true).'/plugins/system/djaccessibility/module/assets/js/accessibility' . $min . '.js', array('version' => $ver));
		
		//inline css styles
		$position = DJAcc::getParam('position', 'sticky');
		$layout = DJAcc::getParam('layout', 'popup');

		if( 'sticky' == $position ) {
			if('popup' == $layout) {
				$voff = DJAcc::getParam('voff_popup', 20);
				$hoff = DJAcc::getParam('hoff_popup', 20);
			} else {
				$voff = DJAcc::getParam('voff_toolbar', 0);
				$hoff = DJAcc::getParam('hoff_toolbar', 0);
			}
			if( $voff > 0 || $hoff > 0 ) $doc->addStyleDeclaration('.djacc { margin: '.$voff.'px '.$hoff.'px; }');
		}

		if( 'popup' == $layout ) {
			$align = DJAcc::getParam('align_popup', 'top right');
			$btn = DJAcc::getParam('image', false);
			$width = DJAcc::getParam('width', 48);
			$height = DJAcc::getParam('height', 48);
			if( $btn ) $doc->addStyleDeclaration('.djacc-popup .djacc__openbtn { width: '.$width.'px; height: '.$height.'px; }');
		} else {
			$align = DJAcc::getParam('align_toolbar', 'top center');
		}

		$align_mobile = DJAcc::getParam('djacc_align_mobile_ch', false);
		$align_mobile_position  = DJAcc::getParam('align_mobile', 'bottom right');
		$direction = DJAcc::getParam('direction', 'top left');
		$space = DJAcc::getParam('space', true);

		$plugin_type = DJAcc::pluginType();

		$options = json_encode(array(
			'yootheme'               => DJACC_YOOTHEME,
			'position'               => $position,
			'layout'                 => $layout,
			'align_position'         => $align,
			'align_mobile'           => $align_mobile,
			'align_mobile_position'  => $align_mobile_position,
			'breakpoint'             => '767px',
			'direction'              => $direction,
			'space'                  => $space,
			'version'                => $plugin_type,
		));

		// init script
		$js = 'new DJAccessibility( ' . $options . ' )';
		$doc->addScriptDeclaration($js);
	}

	function onAfterRender() {

		$app = JFactory::getApplication();
		
		if ( $app->isClient('administrator') ) {
			return;
		}

		$layout = DJAcc::getParam('layout', 'popup');

		$documentFormat = $app->input->getCmd('format', 'html');
	
		if ( ($documentFormat == 'html' || is_null($documentFormat)) ) {

			$html = $app->getBody();
			if( 'toolbar' == $layout ) {
				$accTemplate = DJAcc::getLayout( 'toolbar' );
			} else {
				$accTemplate = DJAcc::getLayout( 'default' );
			}

			if(preg_match("/<body[^>]*>(.*?)<\/body>/is", $html, $matches)) {
				$body = $accTemplate . $matches[1];
				$html = str_replace($matches[1], $body, $html);
			}
			$app->setBody($html);
		}
	}
}