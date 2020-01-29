<?php
return [
    'attributes_path_file' => 'uploads/attributes/',
    'products_path_file'   => 'uploads/products/',
    'carriers_path_file'   => 'uploads/carriers/',
    'payments_path_file'   => 'uploads/payments/',
    'categories_path_file' => 'uploads/categories/',
    'sliders_path_file'    => 'uploads/sliders/',
    'news_path_file'       => 'uploads/news/',

    'social_network' => [
        'instagram' => [
            'url'   => 'https://www.instagram.com/onepoint.kz',
            'token' => '4233405290.1677ed0.e5692138251945c9a0f76180a4885e49',
            'icon'  => '/site/images/social-network/instagram.jpg',
            'title' => 'Вы в Instagram'
        ]
    ],

    'number_phones' => [
        [
            'format'      => '+7 (707) 551-19-79',
            'number'      => '+77075511979',
            'whats_app'   => '7075511979',
            'contactType' => 'Менеджер'
        ]
    ],

    'address' => [
        [
            "streetAddress"   => "ул. Жибек жолы 115, оф. 113",
            "addressLocality" => "г. Алматы",
            "postalCode"      => "050004",
            "addressCountry"  => "Казахстан",
            "working_hours"   => "c 10:00 до 19:00 Без выходных!",
            "geo" => [
                "latitude"  => "43.261664",
                "longitude" => "76.935906"
            ]
        ]
    ],

    'site_email' => 'info@onepoint.kz',
    'logo'    => env('APP_URL') . '/site/images/logo.png',
    'favicon' => env('APP_URL') . '/favicon.ico'
];