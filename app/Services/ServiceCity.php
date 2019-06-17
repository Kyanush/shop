<?php
namespace App\Services;

use App\Models\City;
use Illuminate\Support\Facades\Cookie;

class ServiceCity
{

    private $model;
    public function __construct()
    {
        $this->model = new City();
    }

    public static function listActiveSort(){
        $cities = City::isActive()->OrderBy('sort', 'ASC')->get();
        return $cities;
    }

    public static function groupingFirstLetters(){
        $data = [];
        $cities = self::listActiveSort();
        foreach ($cities as $city)
        {
            $first = mb_strtoupper(mb_substr( $city->name, 0, 1,'UTF8'));
            $data[$first][] = $city;
        }
        return $data;
    }

    public static function getCurrentCity(){

        $parameters = \Route::current()->parameters();
        if(isset($parameters['city']))
        {
            $city_code = $parameters['city'];
        }else{
            $city_code = Cookie::get('city_code');

            if(empty($city_code) or isset($parameters['category']))
                $city_code = 'almaty';
        }

        self::setCityCookie($city_code);

        return City::where('code', $city_code)->first();
    }

    public static function setCityCookie($set_city_code)
    {
        $city_code = Cookie::get('city_code');
        if($city_code != $set_city_code)
        {
            Cookie::queue(Cookie::make('city_code', $set_city_code));
        }
    }

}