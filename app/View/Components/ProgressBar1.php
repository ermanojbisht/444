<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProgressBar1 extends Component
{
    public $type;
    public $title;
    public $percentage;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type='info', $title="give title", $percentage='give percentage')
    {
        $this->type = $type;
        $this->title = $title;
        $this->percentage = $percentage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.progress-bar1');
    }
}
