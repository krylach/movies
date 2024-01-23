<?php

return [
    'suffix_template' => 'template',
    'template_dir' => resources_path('views/'),
    'compile_dir' => tmp_path('compile'),
    'config_dir' => tmp_path('config'),
    'cache_dir' => tmp_path('cache'),
    'debugging' => false,
    'minify' => true,
    'cache' => [
        'enable' => false,
        'life_time' => 86400,
    ]
];
