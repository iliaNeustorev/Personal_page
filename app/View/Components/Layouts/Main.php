<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Main extends Component
{
   
    public function __construct(
        public string $title = 'Личная страница'
        ) {}

    public function render() : View
    {
        return view('components.layouts.main');
    }
}
