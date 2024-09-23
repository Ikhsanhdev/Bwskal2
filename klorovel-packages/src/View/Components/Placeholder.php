<?php

namespace AyatKyo\Klorovel\View\Components;

use Illuminate\View\Component;

class Placeholder extends Component
{
    public $message;
    
    public function __construct($message)
    {
        $this->message = $message;
    }

    public function render()
    {
        return view('klorovel::components.placeholder');
    }
}