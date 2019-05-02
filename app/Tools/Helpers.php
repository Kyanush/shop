<?php
/**
 * Created by PhpStorm.
 * User: Kyanush
 * Date: 27.12.2018
 * Time: 17:23
 */

namespace App\Tools;

use Mobile_Detect;

class Helpers
{

    public static function filtersProductsDecodeUrl($category = ''){
        $params = explode('/', url()->current());
        $filters = [];
        foreach ($params as $key => $param_item)
        {
            if($key < 6) continue;
            $code = explode('-', $param_item)[0];

            $values = str_replace($code . '-', '', $param_item);
            $values = str_replace('?', '', $values);

            $filters[$code] = (strpos($values, '-or-') !== false) ? explode('-or-', $values) : $values;
        }

        if ($category)
            $filters['category'] = $category;

        return $filters;
    }

    public static function generateVisitNumber ()
    {
        if(empty($_COOKIE["visit_number"]))
        {
            $visit_number = sha1(md5(date('Y-m-d H:i:s') . rand(1, 100000000000)));
            setcookie("visit_number", $visit_number, time() + 5000000);
        }
    }

    public static function getVisitNumber()
    {
        return $_COOKIE["visit_number"] ?? '';
    }

    public static function limitWords($string, $word_limit = 10)
    {
        $words = explode(" ", $string);

        if (count($words) > $word_limit) {
            return implode(" ", array_splice($words, 0, $word_limit)) . ' ...';
        }
        return implode(" ", array_splice($words, 0, $word_limit));
    }

    public static function closeTags($content)
    {
        $position = 0;
        $open_tags = array();
        //теги для игнорирования
        $ignored_tags = array('br', 'hr', 'img');

        while (($position = strpos($content, '<', $position)) !== FALSE)
        {
            //забираем все теги из контента
            if (preg_match("|^<(/?)([a-z\d]+)\b[^>]*>|i", substr($content, $position), $match))
            {
                $tag = strtolower($match[2]);
                //игнорируем все одиночные теги
                if (in_array($tag, $ignored_tags) == FALSE)
                {
                    //тег открыт
                    if (isset($match[1]) AND $match[1] == '')
                    {
                        if (isset($open_tags[$tag]))
                            $open_tags[$tag]++;
                        else
                            $open_tags[$tag] = 1;
                    }
                    //тег закрыт
                    if (isset($match[1]) AND $match[1] == '/')
                    {
                        if (isset($open_tags[$tag]))
                            $open_tags[$tag]--;
                    }
                }
                $position += strlen($match[0]);
            }
            else
                $position++;
        }
        //закрываем все теги
        foreach ($open_tags as $tag => $count_not_closed)
        {
            $content .= str_repeat("</{$tag}>", $count_not_closed);
        }

        return $content;
    }

    public static function getSortedToFilter($filters){
        $value   = 'sort_viewed-asc';
        $default = true;

        foreach ($filters as $code => $filter_value)
        {
            if(is_string($filter_value))
            {
                $filter_value = mb_strtolower($filter_value);
                if($filter_value == 'asc' or $filter_value == 'desc')
                {
                    $value = $code . '-' . $filter_value;
                    $default = false;
                    break;
                }
            }
        }

        return [
            'sorting_product' => self::listSortingProducts($value),
            'default'         => $default
        ];
    }

    public static function listSortingProducts($search_value = ''){

        $sorting = [
            [
                'column' => 'viewed',
                'order'  => 'DESC',
                'title'  => 'популярные',
                'value'  => 'sort_viewed-desc'
            ],
            [
                'column' => 'viewed',
                'order'  => 'ASC',
                'title'  => 'популярные',
                'value'  => 'sort_viewed-asc'
            ],
            [
                'column' => 'name',
                'order'  => 'ASC',
                'title'  => 'по названию',
                'value'  => 'sort_name-asc'
            ],
            [
                'column' => 'name',
                'order'  => 'DESC',
                'title'  => 'по названию',
                'value'  => 'sort_name-desc'
            ],
            [
                'column' => 'price',
                'order'  => 'ASC',
                'title'  => 'сначала дешевые',
                'value'  => 'sort_price-asc'
            ],
            [
                'column' => 'price',
                'order'  => 'DESC',
                'title'  => 'сначала дорогие',
                'value'  => 'sort_price-desc'
            ],
            [
                'column' => 'created_at',
                'order'  => 'DESC',
                'title'  => 'новинки',
                'value'  => 'sort_created_at-desc'
            ]
        ];

        if(empty($search_value)){
            return $sorting;
        }else{
            $result = null;
            foreach ($sorting as $item)
            {
                if($item['value'] == $search_value)
                {
                    $result = $item;
                    break;
                }
            }
            return $result ? $result : self::sortingProducts('sort_viewed-asc');
        }
    }

    public static function colorProduct($value){
        $colors = [
            'Gold'=>		'#EC8902',
            'Золотой'=>		'#EC8902',
            'Красный'=>		'#D81D16',
            'Розовое золото'=>		'#E6BEB6',
            'Бамбук'=>		'#74C002',
            'Белый'=>		'#fff',
            'Бирюзовый'=>		'#41E7D5',
            'Голубой'=>		'#00AAEE',
            'Желтый'=>		'#F2BC2C',
            'Зеленый'=>		'#027C02',
            'Розовый'=>		'#C72396',
            'Серебристый'=>		'#E5E6E8',
            'Серый'=>		'#7C7C7C',
            'Синий'=>		'#1F19BC',
            'Тёмно-серый'=>		'#29292B',
            'Фиолетовый'=>		'#6D068F',
            'Черный'=>		'#000',

            'Gray' => '#CDD0D0',
            'Silver' => '#88898B',
            'Black' => '#000000',
            'имеется все цвета' => '#FFFFFF',
            'Red' => '#D90803',
            'Blue' => '#3D7EF1',
            'Sap Blue' => '#013F81',
        ];
        return $colors[$value] ?? '#fff';
    }

    public static function ruDateFormat($date)
    {
        $date = date('d.m.Y', strtotime($date));
        $date = explode(".", $date);

            switch ($date[1]){
                case 1: $m='января'; break;
                case 2: $m='февраля'; break;
                case 3: $m='марта'; break;
                case 4: $m='апреля'; break;
                case 5: $m='мая'; break;
                case 6: $m='июня'; break;
                case 7: $m='июля'; break;
                case 8: $m='августа'; break;
                case 9: $m='сентября'; break;
                case 10: $m='октября'; break;
                case 11: $m='ноября'; break;
                case 12: $m='декабря'; break;
            }
            return $date[0] . ' ' . $m . ' ' . $date[2];
    }


    public static function createTree(&$list, $parentId = null)
    {
        $tree = array();
        foreach ($list as $key => $eachNode) {
            if ($eachNode['parent_id'] == $parentId) {
                $eachNode['children'] = self::createTree($list, $eachNode['id']);
                $tree[] = $eachNode;
                unset($list[$key]);
            }
        }
        return $tree;
    }


    public static function priceFormat($price){
        return number_format($price, 0, ',', ' ') . ' ₸';
    }

    public static function isMobile(){
        //return false;
        //mobile
        $detect = new Mobile_Detect();
        if($detect->isMobile())
            return true;
        else
            return false;
    }


}