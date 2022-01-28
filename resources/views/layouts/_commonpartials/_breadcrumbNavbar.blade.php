@isset ($instance_estimate_id)
    @if($instance_estimate_id)
        <div class="btn-group" role="group" aria-label="Basic example">
            <a class="btn btn-outline-dark" href="{{route('track.estimate.view',$instance_estimate_id)}}" 
                    data-coreui-toggle="tooltip" data-coreui-html="true" data-coreui-placement="bottom" title="<h6>View</h6>">
                <svg class="icon icon-lg">
                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-magnifying-glass')}}"></use>
                </svg>
            </a>
            <a class="btn btn-outline-dark" href="{{route('instanceEstimate.group.index', $instance_estimate_id)}}" 
                    data-coreui-toggle="tooltip" data-coreui-html="true" data-coreui-placement="bottom" title="<h6>Sub-Works</h6>">
               <svg class="icon icon-lg">
                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-fork')}}"></use>
                </svg>
            </a>
            <a class="btn btn-outline-dark" href="{{route('instanceEstimate.instanceEstimateFeature.index',$instance_estimate_id)}}" 
                    data-coreui-toggle="tooltip" data-coreui-html="true" data-coreui-placement="bottom" title="<h6>Features/ Components</h6>">
                <svg class="icon icon-lg">
                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-tags')}}"></use>
                </svg>
            </a>
            <a class="btn btn-outline-dark" href="{{route('instance.estimate.doclist-1',$instance_estimate_id)}}" 
                    data-coreui-toggle="tooltip" data-coreui-html="true" data-coreui-placement="bottom" title="<h6>Documents</h6>">
                <svg class="icon icon-lg">
                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-library')}}"></use>
                </svg>
            </a>
            <a class="btn btn-outline-dark" href="{{route('estimate.villages',$instance_estimate_id)}}" 
                    data-coreui-toggle="tooltip" data-coreui-html="true" data-coreui-placement="bottom" title="<h6>Add village</h6>">
                <svg class="icon icon-lg">
                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-house')}}"></use>
                </svg>
            </a>
            <a class="btn btn-outline-dark" href="{{route('estimate.ulbs',$instance_estimate_id)}}" 
                    data-coreui-toggle="tooltip" data-coreui-html="true" data-coreui-placement="bottom" title="<h6>Add ULB</h6>">
                <svg class="icon icon-lg">
                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-industry')}}"></use>
                </svg>
            </a>
            @isset($instanceMovementAndEstimatePermission)
                <a class="btn btn-outline-dark" href="{{route('estimate.edit', ['estimateId' => $instance_estimate_id])}}" 
                    data-coreui-toggle="tooltip" data-coreui-html="true" data-coreui-placement="bottom" title="<h6>Edit Estimate</h6>">
                    <svg class="icon icon-lg">
                        <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-highlighter')}}"></use>
                    </svg>
                </a>
                <a class="btn btn-outline-dark" href="{{route('estimate.editDetails', ['instance_estimate' => $instance_estimate_id])}}" 
                    data-coreui-toggle="tooltip" data-coreui-html="true" data-coreui-placement="bottom" title="<h6>Edit Estimate Detail</h6>">
                    <svg class="icon icon-lg">
                        <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-pen')}}">Edit Estimate Details</use>
                    </svg>
                </a>
                <a class="btn btn-outline-dark" href="{{route('movement', ['instanceId' => $instance_id,'senderId' => Auth::user()->id])}}" 
                    data-coreui-toggle="tooltip" data-coreui-html="true" data-coreui-placement="bottom" title="<h6>Move</h6>">
                    <svg class="icon icon-lg">
                        <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-transfer')}}"></use>
                    </svg>
                </a>
                <a class="btn btn-outline-dark" href="{{route('editEstimateStatus', ['instanceId' => $instance_id])}}" 
                    data-coreui-toggle="tooltip" data-coreui-html="true" data-coreui-placement="bottom" title="<h6>Update Status</h6>">
                    <svg class="icon icon-lg">
                        <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-clock')}}"></use>
                    </svg>
                </a>
            @endisset
            <a class="btn btn-outline-dark" href="{{route('efc.show',$instance_estimate_id)}}" 
                    data-coreui-toggle="tooltip" data-coreui-html="true" data-coreui-placement="bottom" title="<h6>EFC</h6>">
                <svg class="icon icon-lg">
                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-highligt')}}"></use>
                </svg>
            </a>
        </div>
    @endif
@endisset
