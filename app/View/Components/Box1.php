<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Box1 extends Component
{
    public $type;
    public $title;
    public $dataDetail;
    public $link;
    public $icon;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type='info', $title="give title", $dataDetail='give dataDetail', $link=false, $icon='search')
    {
        $this->type = $type;
        $this->title = $title;
        $this->dataDetail = $dataDetail;
        $this->link = $link;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.box1');
    }
}
