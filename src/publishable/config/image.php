<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',


    'sizes' => [
        'xs'    => 480,
        's'     => 768,
        'm'     => 1024,
        'l'     => 1280,
        'xl'    => 1600,
        'xxl'   => 1920
    ]
];
