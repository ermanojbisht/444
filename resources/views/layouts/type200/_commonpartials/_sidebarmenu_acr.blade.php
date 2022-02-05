<style type="text/css">
    .nav-group .nav-item .nav-link::before {
        content: "\2007 \2007 \2007";
    }
</style>

<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex p-0">
        <svg class="sidebar-brand-full p-0" width="100%" height="46" alt="PWD Logo" style="fill:powderblue;">
            {!!config('mis_entry.svgIcon')['misentry']!!}
        </svg>
        <svg class="sidebar-brand-narrow p-0" width="46" height="46" alt="PWD Logo" style="fill:powderblue;">
            {!!config('mis_entry.svgIcon')['pwd']!!}
        </svg>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-title">Track ACR</li>
        <x-nav-item icon="plus" href="{{route('acr.create')}}">Add New ACR</x-nav-item>
        <x-nav-group icon="book" name="ACR">
            <x-nav-group icon="list-rich" name="ACR List"> 
                <x-nav-item icon="user-plus" href="{{route('acr.myacrs')}}">My ACR</x-nav-item>
                <x-nav-item icon="envelope-letter " href="{{route('acr.others.index')}}">Inbox</x-nav-item>
                <x-nav-item icon="share" href="{{route('sentEstimateInstances')}}">Sent</x-nav-item>
            </x-nav-group>

            @isset ($instance_estimate_id)
                <x-nav-group icon="applications" name="This Estimate (ID - {{$instance_estimate_id}})">
                    @if($instance_estimate_id)
                        <x-nav-item icon="magnifying-glass"
                                    href="{{route('track.estimate.view',$instance_estimate_id)}}">View
                        </x-nav-item>
                        <x-nav-item icon="fork"
                                    href="{{route('instanceEstimate.group.index', $instance_estimate_id)}}">
                            Sub-Works
                        </x-nav-item>
                        <x-nav-item icon="tags"
                                    href="{{route('instanceEstimate.instanceEstimateFeature.index',$instance_estimate_id)}}">
                            Features/ Components
                        </x-nav-item>
                        <x-nav-item icon="library"
                                    href="{{route('instance.estimate.doclist-1',$instance_estimate_id)}}">Documents
                        </x-nav-item>
                        <x-nav-item icon="house"
                                    href="{{route('estimate.villages',$instance_estimate_id)}}">Add village
                        </x-nav-item>
                        <x-nav-item icon="industry"
                                    href="{{route('estimate.ulbs',$instance_estimate_id)}}">Add ULB
                        </x-nav-item>
 
                        @isset($instanceMovementAndEstimatePermission)
                            <x-nav-item icon="highlighter"
                                        href="{{route('estimate.edit', ['estimateId' => $instance_estimate_id])}}">
                                Edit Estimate
                            </x-nav-item>
                            <x-nav-item icon="pen"
                                        href="{{route('estimate.editDetails', ['instance_estimate' => $instance_estimate_id])}}">
                                Edit Estimate Details
                            </x-nav-item>
                            <hr>
                            <x-nav-item icon="transfer"
                                        href="{{route('movement', ['instanceId' => $instance_id,'senderId' => Auth::id()])}}">
                                Move 
                            </x-nav-item>
                            <x-nav-item icon="clock"
                                        href="{{route('editEstimateStatus', ['instanceId' => $instance_id])}}">
                                Update Status
                            </x-nav-item>
                        @endisset
                        <hr>
                        <x-nav-item icon="highligt"
                                    href="{{route('efc.show',$instance_estimate_id)}}">
                            EFC
                        </x-nav-item>
                    @endif
                </x-nav-group>
            @endisset
                <x-nav-group icon="applications" name="Reports">
                   <x-nav-item icon="description" href="{{route('estimate.report')}}">Instance Report</x-nav-item>
                    <x-nav-item icon="list" href="{{route('efc.index')}}">EFC List</x-nav-item>
                </x-nav-group>
            
        </x-nav-group>
 
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
