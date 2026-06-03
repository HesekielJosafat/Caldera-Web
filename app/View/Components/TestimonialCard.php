<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TestimonialCard extends Component
{
    public $image;
    public $quote;
    public $name;
    public $position;
    public $rating;
    
    /**
     * Create a new component instance.
     */
    public function __construct($image, $quote, $name, $position, $rating)
    {
        $this->image = $image;
        $this->quote = $quote;
        $this->name = $name;
        $this->position = $position;
        $this->rating = $rating;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.testimonial-card');
    }
}