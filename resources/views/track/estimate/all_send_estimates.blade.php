{{-- @extends('layouts.type100.main') --}}
@extends('layouts.type200.main')
@section('styles')

<link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="{{ asset('./css/light.css') }}" rel="stylesheet" />

@endsection

@section('sidebarmenu')
    {{-- @include('layouts.type200._commonpartials._sidebarmenu',['active'=>'allEstimateList']) --}}
@endsection

@section('pagetitle')
     xxxxxxxxxxxxxxxx
@endsection

@section('breadcrumb')
    @include('layouts._commonpartials._breadcrumb',
        ['datas'=> [
            ['label'=>'Add Detail','active'=>true],
                    ]  
        ])
@endsection

@section('content')

<div class="card">
    <div class="card-header bg-primary">
        <h5 class="card-title text-white d-flex justify-content-between align-items-center">
            Add Estimate
            <a class="btn btn-sm btn-light " href="{{route('instance.create')}}">
                {!!config('mis_entry.svgIcon')['plus']!!}
                Create New
            </a>
        </h5>
    </div>
    <div class="card-body">
        <div>
            <td style="text-align:center">
                <a class="btn btn-sm btn-square btn-warning" data-toggle="tooltip" data-placement="left" title="View "
                    href="#">
                    {!!config('mis_entry.svgIcon')['viewDoc']!!}
                    <span class="align-middle"> View </span>
                </a>

                <a class="btn btn-sm  btn-square btn-primary" href="#">
                    {!!config('mis_entry.svgIcon')['addDoc']!!}
                    <span> Add Estimate </span>
                </a>

                <a class="btn btn-sm  btn-square btn-secondary" href="#">
                    {!!config('mis_entry.svgIcon')['addDoc']!!}
                    <span class="align-middle"> Add Estimate Details </span>
                </a>

                <a class="btn btn-sm  btn-square btn-success" href="#">
                    {!!config('mis_entry.svgIcon')['FF']!!}
                    <span> Move instance </span>
                </a>

                <a class="btn btn-sm btn-square btn-info" href="#">
                    {!!config('mis_entry.svgIcon')['skip']!!}
                    <span> Update Status </span>
                </a>
            </td>
        </div>


        <div class="row">

            <table id="user_Request_Details" class="table table-bordered table-striped dataTable dtr-inline">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Estimate Name</th>
                        <th>Created By</th>
                        <th>Created on</th>
                        <th>Current Status</th>
                        <th>Currently With</th>
                        <th> View Instance</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($instances as $instance)
                    <tr>
                        <td>{{1+$loop->index}} </td>
                        <td>{{$instance->instance_name}}</td>
                        <td> {{$instance->creator->name}} ({{$instance->creator->designation}})</td>
                        <td> {{$instance->created_at->format('d / m / Y')}} </td>

                        @if($instance->currentStatus)

                        <td> {{$instance->currentStatus->name}} </td>
                        @else
                        <td>not known</td>
                        @endif
                        <td>
                            @if($instance->lastHistory())
                            {{$instance->lastHistory()->emp_name}}
                            @endif
                        </td>
                        <td style="text-align:center">


                            @if($instance->instance_type_id == 1 )
                            <a class="btn btn-sm  btn-square btn-warning" data-toggle="tooltip" data-placement="left"
                                title="View " href="{{route('view', ['estimateId' => $instance->id])}}">
                                {!!config('mis_entry.svgIcon')['viewDoc']!!}
                            </a>

                            @if($instance->user_id == Auth::user()->id)
                            @if(! $instance->estimate)

                            <a class="btn btn-sm  btn-square btn-primary" data-toggle="tooltip" data-placement="left"
                                title="Add Estimate" href="{{route('estimate.create', ['id' => $instance->id])}}">
                                {!!config('mis_entry.svgIcon')['addDoc']!!}
                            </a>
                            @else

                            @if(! $instance->estimate->road_length &&
                            ! $instance->estimate->bridge_no &&
                            ! $instance->estimate->bridge_span &&
                            ! $instance->estimate->building_no)

                            <a class="btn btn-sm btn-square btn-secondary" data-toggle="tooltip" data-placement="left"
                                title="Add Estimate Details"
                                href="{{route('estimate.addDetails', ['id' => $instance->id])}}">
                                {!!config('mis_entry.svgIcon')['addDoc']!!}
                            </a>

                            @else



                            <a class="btn btn-sm btn-square btn-success" data-toggle="tooltip" data-placement="left"
                                title="Move instance "
                                href="{{route('movement', ['estimateId' => $instance->id,'senderId' => Auth::user()->id])}}">
                                {!!config('mis_entry.svgIcon')['FF']!!}
                            </a>

                            <a class="btn btn-sm btn-square btn-info" data-toggle="tooltip" data-placement="left"
                                title="Move instance "
                                href="{{route('update_estimate_status', ['estimateId' => $instance->id,'senderId' => Auth::user()->id])}}">
                                {!!config('mis_entry.svgIcon')['skip']!!}
                            </a>

                            @endif


                            @endif

                            @endif


                            @if($instance->lastHistory())
                                @if($instance->user_id != Auth::user()->id && @ $instance->lastHistory()->to_id ==
                                Auth::user()->id)
                                <a class="btn btn-sm btn-square btn-success" data-toggle="tooltip" data-placement="left" title="Move instance " 
                                     href="{{route('movement', ['estimateId' => $instance->id,'senderId' => Auth::user()->id])}}">
                                    {!!config('mis_entry.svgIcon')['FF']!!}
                                </a>

                                @endif
                            @endif

                            
                        @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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