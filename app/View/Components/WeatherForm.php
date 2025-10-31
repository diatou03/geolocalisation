<?php

namespace App\View\Components;

use Illuminate\View\Component;

class WeatherForm extends Component
{
    public $city;

    public function __construct($city = null)
    {
        $this->city = $city;
    }

    public function render()
    {
        return view('components.weather-form');
    }
}
