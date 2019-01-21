<?php
namespace App\Services;

use App\Models\Slider;

class ServiceSlider
{

    private $model;
    public function __construct()
    {
        $this->model = new Slider();
    }

    public function listSlidersHomePage(){
        return $this->model->where('show_where', 'home_page')->isActive()->OrderBy('sort')->get();
    }

}