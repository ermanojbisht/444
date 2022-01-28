<?php

namespace App\View\Components\Track;

use App\Models\Track\InstanceEstimate;
use App\Models\Work;
use Illuminate\View\Component;
use Log;

class InstanceEstimateHeader extends Component
{
    /**
     * @var mixed
     */
    public $instanceEstimate;
    /**
     * @var mixed
     */
    public $pagetitle;
    /**
     * @var mixed
     */
    public $toBackroutename;
    /**
     * @var mixed
     */
    public $routeParameter;
    /**
     * @var mixed
     */
    public $routelabel;
    /**
     * @var mixed
     */
    public $work_name;
    /**
     * @var mixed
     */
    public $WORK_code;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(InstanceEstimate $instanceEstimate, $pagetitle, $toBackroutename, $routeParameter, $routelabel)
    {
        //Log::info("instanceEstimate = ".print_r($instanceEstimate, true));
        $this->instanceEstimate = $instanceEstimate;
        $this->pagetitle = $pagetitle;
        $this->toBackroutename = $toBackroutename;
        $this->routeParameter = $routeParameter;
        $this->routelabel = $routelabel;
        if ($instanceEstimate->WORK_code) {
            $this->WORK_code = $instanceEstimate->WORK_code;
            $work = Work::find($this->WORK_code);
            if ($work) {
                $this->work_name = $work->WORK_name;
            } else {
                $this->work_name = "$this->WORK_code is not proper work code";
            }
        } else {
            $this->WORK_code = $this->work_name = false;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.track.instance-estimate-header');
    }
}
