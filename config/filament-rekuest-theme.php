<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default variant
    |--------------------------------------------------------------------------
    |
    | The variant used when the plugin is registered without an explicit one.
    | Must match one of the keys defined under "variants" below.
    |
    */

    'default' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Available theme variants
    |--------------------------------------------------------------------------
    |
    | Each variant points to a precompiled CSS file (relative to the package
    | root) that styles the Filament panel. Each stylesheet MUST support both
    | light and dark mode (Filament toggles the `.dark` class on <html>).
    |
    | You can publish this config and add your own variants, or contribute new
    | ones to the package.
    |
    */

    'variants' => [

        'default' => [
            'label' => 'Default',
            'path' => 'dist/themes/default.css',
        ],

    ],

];
