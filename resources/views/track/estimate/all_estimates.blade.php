@extends('layouts.type200.main')
@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
@endsection
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu',['active'=>$selectedMenu])
@endsection

@section('pagetitle')
     {{$reportTitle}}
@endsection

@section('breadcrumbNevigationButton')
        <div class="btn-group" role="group" aria-label="Basic example">
            <a class="btn btn-outline-dark" href="{{route('index')}}" 
                    data-coreui-toggle="tooltip" data-coreui-html="true" data-coreui-placement="bottom" title="<h6>All Estimate</h6>">
                <svg class="icon icon-lg">
                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-storage')}}"></use>
                </svg>
            </a>
            <a class="btn btn-outline-dark" href="{{route('myInstances')}}" 
                    data-coreui-toggle="tooltip" data-coreui-html="true" data-coreui-placement="bottom" title="<h6> My Estimate</h6>">
               <svg class="icon icon-lg">
                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-user-plus')}}"></use>
                </svg>
            </a>
            <a class="btn btn-outline-dark" href="{{route('receivedInstances')}}" 
                    data-coreui-toggle="tooltip" data-coreui-html="true" data-coreui-placement="bottom" title="<h6>Inbox</h6>">
                <svg class="icon icon-lg">
                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-envelope-letter')}}"></use>
                </svg>
            </a>
            <a class="btn btn-outline-dark" href="{{route('sentEstimateInstances')}}" 
                    data-coreui-toggle="tooltip" data-coreui-html="true" data-coreui-placement="bottom" title="<h6>Sent</h6>">
                <svg class="icon icon-lg">
                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-share')}}"></use>
                </svg>
            </a>
            <a class="btn btn-outline-dark" href="{{route('efc.index')}}" 
                    data-coreui-toggle="tooltip" data-coreui-html="true" data-coreui-placement="bottom" title="<h6>EFC List</h6>">
                <svg class="icon icon-lg">
                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-list')}}"></use>
                </svg>
            </a>
        </div>
@endsection

@section('breadcrumb')
      @include('layouts._commonpartials._breadcrumb',
            [   'datas'=> [
                            ['label'=>'Estimate','active'=>false],
                            ['label'=>$reportTitle,'active'=>true],
                        ]  
            ])
@endsection

@section('content')
<div class="card">
    <div class="d-flex justify-content-end bg-transparent">
        <a class="btn btn-sm btn-dark m-2 " href="{{route('instance.create')}}">
            <svg class="icon">
              <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
            </svg>
            Create New
        </a>
    </div>
    {{-- <div class="table-responsive"> --}}
        <table class="table border mb-0">
            <thead class="table-light  fw-bold">
                <tr class="align-middle">
                    <th>#</th>
                    <th class="text-center">Description</th>
                    <th>Created By</th>
                    <th class="text-center">Created on</th>
                    @if($selectedMenu == 'receivedInstances')
                    <th>Received on</th>
                    @endif
                    @if($selectedMenu == 'sentInstances')
                    <th>Send on</th>
                    @endif
                    <th>Status</th>
                    <th>Currently With</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($instances as $instance)
                <tr>
                    <td>{{1+$loop->index}} </td>
                    <td>{{$instance->instance_name}}</td>
                    <td> {{$instance->creator->name}} ({{$instance->creator->designation}})</td>
                    <td> {{$instance->created_at->format('d M Y')}} </td>
                    @if($selectedMenu == 'receivedInstances')
                        <td>
                        @foreach($instance->history as $history)
                            @if($history->to_id == Auth::User()->id && $history->action_taken == 0)
                                 {{$instance->created_at->format('d M Y')}} 
                                    @break
                            @endif
                        @endforeach
                    </td>
                    @endif
                    @if($selectedMenu == 'sentInstances')
                    <td>
                        @foreach($instance->history as $history)
                            @if($history->from_id == Auth::User()->id && $history->action_taken == 0)
                                 {{$instance->created_at->format('d M Y')}} 
                                    @break
                            @endif
                        @endforeach
                    </td>
                    @endif
                    <td>
                        @if($instance->currentStatus)
                            {{$instance->currentStatus->name}}
                        @else
                            not known
                        @endif
                    </td>
                    <td>
                        @if($instance->lastHistory())
                            {{$instance->lastHistory()->emp_name}}
                        @endif 
                    </td>
                    <td>
                         <div class="dropdown dropstart">
                            <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                <svg class="icon icon-xl" >
                                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-options')}}"></use>
                                </svg>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                @if($instance->estimate) 
                                <a class="dropdown-item" href="{{route('track.estimate.view', ['instance_estimate' => $instance->estimate->id])}}">
                                    <i class="cib-twitter"></i>View
                                </a> 
                                <a class="dropdown-item" href="{{route('efc.show', ['instance_estimate' => $instance->estimate->id])}}">
                                    <i class="cib-twitter"></i>EFC
                                </a>
                                @endif
                                @if(($instance->user_id == Auth::user()->id) || 
                                ($instance->lastHistory() && $instance->lastHistory()->to_id 
                                && $instance->lastHistory()->to_id == Auth::user()->id)) 

                                    @if(! $instance->estimate) 
                                        <a class="dropdown-item" href="{{route('estimate.create', ['id' => $instance->id])}}">
                                            Add Estimate
                                        </a>
                                    @else
                                        <a class="dropdown-item" href="{{route('estimate.edit', ['estimateId' => $instance->estimate->id])}}">
                                            Edit Estimate 
                                        </a>
                                        <a class="dropdown-item" href="{{route('estimate.editDetails', ['instance_estimate' => $instance->estimate->id])}}">
                                            Edit Estimate Details
                                        </a>
                                        <a class="dropdown-item" href="{{route('movement', ['instanceId' => $instance->id,'senderId' => Auth::user()->id])}}">
                                            Move instance
                                        </a>
                                        <a class="dropdown-item" href="{{route('editEstimateStatus', ['instanceId' => $instance->id])}}">
                                            Update instance
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    {{-- </div> --}}
</div>

@endsection



@section('footscripts')
<script src="{{ asset('../plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#success-alert").fadeTo(5000, 500).slideUp(500, function () {
            $("#success-alert").slideUp(500);
        });
    });

        document.addEventListener("DOMContentLoaded", function () {
            // Datatables Responsive
            $("#user_Request_Details").DataTable({
                responsive: true
            });
        });
</script>

@endsection
