<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Main extends Component
{
    
    /**
     *
     * @param string $title
     */
    public function __construct(
        public string $title = 'Личная страница'
        ) {}
    
    /**
     *
     * @return View
     */
    public function render() : View
    {
        return view('components.layouts.main');
    }
}
