<?php
if(env('APP_NO_URL') == 'ShopX.kz')
{
    return [
        'attributes_path_file' => 'uploads/attributes/',
        'products_path_file' => 'uploads/products/',
        'carriers_path_file' => 'uploads/carriers/',
        'payments_path_file' => 'uploads/payments/',
        'categories_path_file' => 'uploads/categories/',
        'sliders_path_file' => 'uploads/sliders/',

        'social_network' => [
            'instagram' => 'https://www.instagram.com/shopx.kz'
        ],

        'number_phones' => [
            [
                'format' => '+7 (708) 961-92-25',
                'number' => '+77089619225',
                'contactType' => 'Менеджер'
            ]
        ],

        'address' => [
            [
                "streetAddress" => "ул. Жибек жолы 115, оф. 113 (Рядом Аэровокзала)",
                "addressLocality" => "г. Алматы",
                "postalCode" => "050004",
                "addressCountry" => "Казахстан",
                "working_hours" => "c 10:00 до 19:00 Без выходных!",
                "geo" => [
                    "latitude" => "43.261664",
                    "longitude" => "76.935906"
                ]
            ]
        ],

        'site_email' => 'shopx.kz@gmail.com',
        'logo' => env('APP_URL') . '/site/images/logo.png'

    ];
}

if(env('APP_NO_URL') == 'OnePoint.kz')
{
    return [
        'attributes_path_file' => 'uploads/attributes/',
        'products_path_file'   => 'uploads/products/',
        'carriers_path_file'   => 'uploads/carriers/',
        'payments_path_file'   => 'uploads/payments/',
        'categories_path_file' => 'uploads/categories/',
        'sliders_path_file'    => 'uploads/sliders/',

        'social_network' => [
            'instagram' => 'https://www.instagram.com/onepoint.kz'
        ],

        'number_phones' => [
            [
                'format'      => '+7 (707) 551-19-79',
                'number'      => '+77075511979',
                'contactType' => 'Менеджер'
            ]
        ],

        'address' => [
            [
                "streetAddress"   => "ул. Жибек жолы 115, оф. 113 (Рядом Аэровокзала)",
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
        'logo'       =>  env('APP_URL') . '/site/images/logo.png'

    ];
}