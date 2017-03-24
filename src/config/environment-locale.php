<?php

return [

    'passive' => true,

    'equivalences' => [
        'en' => 'en_US',
    ],

    'transformations' => [
        'Wizclumsy\Utils\Library\EnvironmentLocale@replaceUnderscoreTransformation',
        'Wizclumsy\Utils\Library\EnvironmentLocale@replaceDashTransformation',
        'Wizclumsy\Utils\Library\EnvironmentLocale@duplicateLocaleTransformation',
    ],

    'append' => [
        '.UTF-8',
        '.utf8',
    ],

    'fallbacks' => [
        'de-AT' => 'de',
        'de-CH' => 'de',
        'de'    => 'de-AT',
        'en-GB' => 'en',
        'en-AU' => 'en',
        'en-US' => 'en',
        'en'    => 'en-GB',
        'pt-BR' => 'pt',
        'pt'    => 'pt-BR',
    ],

];
