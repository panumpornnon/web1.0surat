<?php

namespace YOOtheme;

return array(

    'name' => 'extension/pro',

    'autoload' => array(
        'YOOtheme\\Widgetkit\\Pro\\' => 'src'
    ),

    'events' => array(

        'init' => function() {
            if (class_exists(Application::class, false)
                && method_exists(Application::class, 'getInstance')
                && method_exists(Application::class, 'load')
            ) {
                $app = Application::getInstance();
                $app->load(__DIR__ . '/bootstrap.php');
            }
        }

    )

);
