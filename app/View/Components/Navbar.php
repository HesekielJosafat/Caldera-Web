<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Navbar extends Component
{
    public $transparent;
    
    /**
     * Create a new component instance.
     */
    public function __construct($transparent = true)
    {
        $this->transparent = $transparent;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.navbar');
    }
}