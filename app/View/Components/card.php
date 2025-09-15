<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class card extends Component
{
    public $image;
    public $title;
    public $description;
    public $buttonText;
    /**
     * Create a new component instance.
     */
    public function __construct($image, $title, $description, $buttonText)
    {
        $this->image = $image;
        $this->title = $title;
        $this->description = $description;
        $this->buttonText = $buttonText;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card');
    }
}
