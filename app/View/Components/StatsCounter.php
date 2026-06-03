<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StatsCounter extends Component
{
    public $id;
    public $value;
    public $label;
    public $icon;
    public $color;
    public $delay;
    
    /**
     * Create a new component instance.
     */
    public function __construct($id, $value, $label, $icon, $color, $delay = 0)
    {
        $this->id = $id;
        $this->value = $value;
        $this->label = $label;
        $this->icon = $icon;
        $this->color = $color;
        $this->delay = $delay;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.stats-counter');
    }
}