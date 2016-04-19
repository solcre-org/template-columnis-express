<?php

return array(
    'gk_smarty' => array(
        /**
         * Template suffix.
         */
        'suffix' => 'tpl',
        /**
         * Directory for compiled templates.
         */
        'compile_dir' => getcwd() . '/data/templates_c',
        /**
         * Directory for cached templates.
         */
        'cache_dir' => getcwd() . '/data/cache/templates',
        
        /**
         * Smarty engine options.
         */
        'smarty_options' => array(
            /**
             * Directory for cached templates.
             */
            'template_dir' => getcwd() . '/public/templates'
        ),
    ),
);