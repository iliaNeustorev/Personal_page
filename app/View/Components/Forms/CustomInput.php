<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class CustomInput extends Component
{
    /**
     *
     * @param string $name
     * @param string $label
     * @param string $placeholder
     * @param string $icon
     * @param string $type
     */
    public function __construct(
        public string $name,
        public string $label = '',
        public string $placeholder= '',
        public string $icon = '',
        public string $type = 'text'
        ) {}

    /**
     *
     * @return View
     */
    public function render() : View
    {
        return view('components.forms.custom-input');
    }
}
