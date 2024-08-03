<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Notifications extends Component
{
    /**
     *
     * @param string|null $message
     * @param boolean $hasMessage
     * @param array $messages
     */ 
    public function __construct(
        public string|null $message,
        public bool $hasMessage,
        public array $messages,
    )
    {
        $this->message = session()->get('notification');
        $this->hasMessage = $this->message !== null;
        $this->messages = $this->hasMessage ? config('app-notifications') : [];
    }

    /**
     *
     * @return View
     */
    public function render() : View
    {
        return view('components.notifications');
    }
}
