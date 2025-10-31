<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public function __construct(
        public string $href,
        public string $title,
        public string $description
    ) {}

    public function render()
    {
        return view('components.card');
    }
}
