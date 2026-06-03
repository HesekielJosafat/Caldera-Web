<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FeatureCard extends Component
{
    public $icon;
    public $gradient;
    public $title;
    public $description;
    public $feature;
    public $delay;
    
    /**
     * Create a new component instance.
     */
    public function __construct($icon, $gradient, $title, $description, $feature, $delay = 0)
    {
        $this->icon = $icon;
        $this->gradient = $gradient;
        $this->title = $title;
        $this->description = $description;
        $this->feature = $feature;
        $this->delay = $delay;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.feature-card');
    }
}