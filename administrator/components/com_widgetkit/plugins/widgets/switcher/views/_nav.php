<?php

// Nav
$nav_item = '';

if ($settings['nav'] == 'tabs') {

    $nav = in_array($settings['position'], array('left', 'right')) ? '{wk}-tab {wk}-tab-'. $settings['position'] : '{wk}-tab';

    // Alignment
    if (in_array($settings['position'], array('top', 'bottom'))) {

        $nav .= in_array($settings['alignment'], array('center', 'right')) ? ' {wk}-flex-' . $settings['alignment'] : '';
        $nav .= $settings['alignment'] == 'justify' ? ' {wk}-child-width-expand' : '';

    }

    $javascript = 'tab';

} else {

    if ($settings['position'] == 'top' || $settings['position'] == 'bottom') {

        switch ($settings['nav']) {
            case 'text':
                $nav = '{wk}-subnav';
                break;
            case 'lines':
                $nav = '{wk}-subnav {wk}-subnav-divider';
                break;
            case 'nav':
                $nav = '{wk}-subnav {wk}-subnav-pill';
                break;
            case 'thumbnails':
                $nav = '{wk}-thumbnav';
                $nav_item = ($settings['alignment'] == 'justify') ? ' class="{wk}-width-1-' . count($items) . '"' : '';
                break;
            case 'dotnav':
                $nav = '{wk}-dotnav';
                break;
        }

        // Alignment
        $nav .= ($settings['alignment'] != 'justify') ? ' {wk}-flex-' . $settings['alignment'] : '';

    } else {

        switch ($settings['nav']) {
            case 'text':
                $nav = '{wk}-list {wk}-list-large';
                break;
            case 'lines':
                $nav = '{wk}-list {wk}-list-divider';
                break;
            case 'nav':
                $nav = '{wk}-nav {wk}-nav-default';
                break;
            case 'thumbnails':
                $nav = '{wk}-thumbnav {wk}-flex-column';
                break;
            case 'dotnav':
                $nav = '{wk}-dotnav {wk}-flex-column';
                break;
        }

    }

    $javascript = 'switcher';

}

// Animation
$animation = ($settings['animation'] != 'none') ? '; animation: ' . '{wk}-animation-' . $settings['animation'] : '';

// Disable swiping
$swiping = ($settings['disable_swiping']) ? '; swiping: false' : '';

?>

<div class="uk-hidden@s mobile-dropdown-switcher" id="wk-mobile-dropdown-<?= $settings['id'] ?>">
<?php if(count($items)): ?>
    <button class="uk-button uk-button-default uk-width-1-1"><?= strip_tags($items[0]['title']) ?></button>
    <div uk-dropdown="mode: click" style="width: 100%;">
        <ul class="{wk}-nav {wk}-nav-default">
            <?php foreach ($items as $index => $item) : ?>
                <?php

                    // Alternative Media Field
                    $field = 'media';
                    if ($settings['thumbnail_alt']) {
                        foreach ($item as $media_field) {
                            if (($item[$media_field] != $item['media']) && ($item->type($media_field) == 'image')) {
                                $field = $media_field;
                                break;
                            }
                        }
                    }

                    // Thumbnails
                    $thumbnail = '';
                    if ($settings['nav'] == 'thumbnails' &&  ($item->type($field) == 'image' || $item[$field . '.poster'])) {

                        $attrs           = array();
                        $width           = ($settings['thumbnail_width'] != 'auto') ? $settings['thumbnail_width'] : $item[$field . '.width'];
                        $height          = ($settings['thumbnail_height'] != 'auto') ? $settings['thumbnail_height'] : $item[$field . '.height'];

                        $attrs['alt']    = strip_tags($item['title']);
                        $attrs['width']  = $width;
                        $attrs['height'] = $height;

                        if ($settings['thumbnail_width'] != 'auto' || $settings['thumbnail_height'] != 'auto') {
                            $thumbnail = $item->thumbnail($item->type($field) == 'image' ? $field : $field . '.poster', $width, $height, $attrs);
                        } else {
                            $thumbnail = $item->media($item->type($field) == 'image' ? $field : $field . '.poster', $attrs);
                        }
                    }

                ?>
                <li<?= $nav_item ?>><a href="" class="uk-dropdown-close" onclick="UIkit.switcher('#wk-<?= $settings['id'] ?>').show(<?= $index ?>); document.querySelector('#wk-mobile-dropdown-<?= $settings['id'] ?> > .uk-button').innerHTML = '<?= strip_tags($item['title']) ?>';"><?= $thumbnail ?: $item['title'] ?></a></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif; ?>
</div>

<div class="uk-visible@s">
    <ul class="<?= $nav ?>" {wk}-<?= $javascript ?>="connect: #wk-<?= $settings['id'] ?><?= $animation ?><?= $swiping ?>" <?= $settings['position'] == 'top' || $settings['position'] == 'bottom' ? '{wk}-margin' : '' ?>>
    <?php foreach ($items as $item) : ?>
        <?php

            // Alternative Media Field
            $field = 'media';
            if ($settings['thumbnail_alt']) {
                foreach ($item as $media_field) {
                    if (($item[$media_field] != $item['media']) && ($item->type($media_field) == 'image')) {
                        $field = $media_field;
                        break;
                    }
                }
            }

            // Thumbnails
            $thumbnail = '';
            if ($settings['nav'] == 'thumbnails' &&  ($item->type($field) == 'image' || $item[$field . '.poster'])) {

                $attrs           = array();
                $width           = ($settings['thumbnail_width'] != 'auto') ? $settings['thumbnail_width'] : $item[$field . '.width'];
                $height          = ($settings['thumbnail_height'] != 'auto') ? $settings['thumbnail_height'] : $item[$field . '.height'];

                $attrs['alt']    = strip_tags($item['title']);
                $attrs['width']  = $width;
                $attrs['height'] = $height;

                if ($settings['thumbnail_width'] != 'auto' || $settings['thumbnail_height'] != 'auto') {
                    $thumbnail = $item->thumbnail($item->type($field) == 'image' ? $field : $field . '.poster', $width, $height, $attrs);
                } else {
                    $thumbnail = $item->media($item->type($field) == 'image' ? $field : $field . '.poster', $attrs);
                }
            }

        ?>
        <li<?= $nav_item ?>><a href=""><?= $thumbnail ?: $item['title'] ?></a></li>
    <?php endforeach ?>
    </ul>
</div>
