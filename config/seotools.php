<?php
/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults' => [
            'title' => env('APP_NAME'), // set false to total remove
            'titleBefore' => false, // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description' => false, // set false to total remove
            'separator' => ' - ',
            'keywords' => [],
            'canonical' => 'current', // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'robots' => false, // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google' => env('SEOTOOLS_GOOGLE', null),
            'yandex' => env('SEOTOOLS_YANDEX', null),
            'bing' => null,
            'alexa' => null,
            'pinterest' => null,
            'norton' => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */

        'defaults' => [
            'title' => env('APP_NAME'), // set false to total remove
            'description' => false, // set false to total remove
            'url' => null, // Set null for using Url::current(), set false to total remove
            'type' => false,
            'site_name' => env('APP_NAME'),
            'locale' => 'ru_RU',
            'images' => [
                [
                    env('APP_URL') . '/assets/images/logo.png',
                    ['width' => 1200, 'height' => 630],
                ],
            ],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            //'card'        => 'summary',
            //'site'        => '@LuizVinicius73',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title' => env('APP_NAME'), // set false to total remove
            'description' => false, // set false to total remove
            'url' => 'current', // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'type' => 'WebPage',
            'images' => [
                [
                    env('APP_URL') . '/assets/images/logo.png',
                    ['width' => 1200, 'height' => 630],
                ],
            ],
        ],
    ],
];
