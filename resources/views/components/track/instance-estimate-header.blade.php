<div class="card">
    <div class="card-body">
        <div class="d-flex h4 fw-semibold">
                @if($toBackroutename)
                    <a href="{{ route($toBackroutename,$routeParameter) }}">
                        <svg style="width: 24px; height: 24px;">
                            <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-magnifying-glass')}}"></use>
                        </svg>
                    </a>
                @endif
                <span>{{$instanceEstimate->instance->instance_name??'' }}</span>
        </div>
        <div class="p-2 border-top border-bottom">
            @if($WORK_code)
                <a  class="btn btn-sm btn-outline-info" target="_blank"
                    href="{{config('site.app_url_mis').'/'.config('site.missite_workdetail_address').'/'.$instanceEstimate->WORK_code}}">
                    {{$instanceEstimate->WORK_code}}
                </a>
                <span class="fw-semibold h5 text-info fst-italic"> {{$work_name??''}} </span>
            @else
                <span class="fw-semibold h5 text-info fst-italic">Estimate Not Associated with Any Sanctioned work</span>
            @endif
        </div>
         @if($instanceEstimate->reference_no)
            @php
                $reffereneDetails="having refferene no $instanceEstimate->reference_no" ;
                $dueToDetail="due to ".config('mis_entry.estimate.due_to')[$instanceEstimate->due_to]
            @endphp
        @else
            @php $reffereneDetails=$dueToDetail="" @endphp
        @endif
        
        <div class="h5">
            @if($instanceEstimate->estimate_cost)
                <p class="fw-semibold ">Estimated Cost:  {{number_format($instanceEstimate->estimate_cost,2)}}  Lacs</p>
            @endif
            Estimate has been created {{"$dueToDetail $reffereneDetails"}}
        </div>

    </div>
</div>
