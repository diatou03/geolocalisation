<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TideForm extends Component
{
    public $cities;
    public $location;
    public $commune;
    public $date;

    public function __construct($cities, $location, $commune, $date)
    {
        $this->cities = $cities;
        $this->location = $location;
        $this->commune = $commune;
        $this->date = $date;
    }

    public function render()
    {
        return view('components.tide-form');
    }
}
