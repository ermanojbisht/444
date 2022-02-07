@extends('layouts.type200.main')

@section('headscripts')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-selection__rendered {
            line-height: 18px !important;
        }

        .table>:not(:last-child)>:last-child>*,
        .table tbody,
        .table td,
        .table tfoot,
        .table th,
        .table thead,
        .table tr {
            border-color: transparent !important;
        }
    </style>
@endsection

@section('sidebarmenu')
    {{-- @include('layouts.type200._commonpartials._sidebarmenu',['instance_estimate_id'=>$instanceEstimate->id??0, 'instance_id'=>$instanceEstimate->instance_id]) --}}
@endsection

@section('pagetitle')
     Estimate Movement
@endsection

@section('breadcrumbNevigationButton')
    @include('layouts._commonpartials._breadcrumbNavbar',
                ['instance_estimate_id'=>$instanceEstimate->id??0,'instance_id'=>$instanceEstimate->instance_id])
@endsection

@section('breadcrumb')
    @include('layouts._commonpartials._breadcrumb',
        ['datas'=> [
            ['label'=>'Estimates','active'=>false],
            ['label'=>'Estimate ID- '.$instance->id,'active'=>false],
            ['label'=>'Movement','active'=>true],
                    ]  
        ])
@endsection

@section('content')
    @include("track.estimate.partial._EstimateInfo",[
        'instance' => $instance,
        'addDetails' => false,
        'instanceEstimate' => $instanceEstimate,
        'blocks' => $instance_blocks,
        'Constituencies' => $instance_constituencies
    ])

<div class="container-fluid">
    <div class="card callout callout-info">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    @if(Session::has('update_scs'))
                    <div id="success-alert" class="card-body">
                        <div class="alert alert-success alert-dismissible">
                            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                            {{ Session::get('update_scs')}}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <form action="{{ route('storeEstimateMovements') }}" method="POST">
                    @csrf
                    <div class="box-header">
                        <input type="hidden" name="instance_id" value="{{  $instance->id }}">
                        <input type="hidden" name="current_status" value="{{  $instance->status_master_id }}">
                    </div>
                    <div class="box-body">
                        @if($instance->user_id == Auth::user()->id)
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="sender_id" class="col-form-label">Instance Sender :</label>
                            </div>
                            <div class="col-auto">
                                <select id="sender_id" name="sender_id" tabindex="2" aria-hidden="true"
                                    class="form-control select2  ">
                                    <option value="0">select Registred Sender Officer </option>
                                    @foreach($senderList as $user)
                                    <option {{ ($sender==$user->id) ? "selected" : "" }}
                                        value="{{$user->id}}"> {{$user->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @else
                        <input type="hidden" id="sender_id" name="sender_id" value="{{ $sender }}" />
                        @endif
                        <hr>
                        <div class="row">
                            <div class="card col-md-4">
                                <h5 class="card-header bg-info fs-4 fw-bold text-white">Move to Registered Employee:
                                </h5>
                                <div class="card-body form-group">
                                    <div class="row g-1 align-items-center">
                                        <div class="col-4">
                                            <label for="registredUsers" class="col-form-label">Select Name</label>
                                        </div>
                                        <div class="col-8">
                                            <select id="registredUsers" name="registredUsers[]" multiple="multiple"
                                                tabindex="2" aria-hidden="true" class="select2">
                                                <option value="0" disabled>select Registred Sender Officer </option>
                                                @foreach($recipentList as $user)
                                                <option value="{{$user->id}}"> {{$user->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card col-md-4">
                                <h5 class="card-header bg-info fs-4 fw-bold text-white">Move to Un-Registered Employee:
                                </h5>
                                <div class="card-body form-group">
                                    <div class="row g-1 align-items-center">
                                        <div class="col-4">
                                            <label for="designation" class="col-form-label">Designation</label>
                                        </div>
                                        <div class="col-8">
                                            <select class=" select2" id="designation" name="designation" tabindex="1"
                                                style="width:250px;" onchange="getEmployeeDesignationWise()">
                                                <option value="0" disabled>Select
                                                    Designation
                                                </option>
                                                @foreach($designations as
                                                $designation)
                                                <option value="{{$designation->id}}">
                                                    {{$designation->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row g-1 align-items-center">
                                        <div class="col-4">
                                            <label for="employees" class="col-form-label">Name</label>
                                        </div>
                                        <div class="col-8">
                                            <select id="employees" name="employees[]" multiple="multiple" tabindex="2"
                                                aria-hidden="true" class="select2">
                                                <option value="0">select Employees
                                                </option>
                                                @foreach($employees as $employee)
                                                <option value="{{$employee->id}}">
                                                    {{$employee->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card col-md-4">
                                <h5 class="card-header bg-info fs-4 fw-bold text-white">Move to External Office:</h5>
                                <div class="card-body form-group">
                                    <div class="row g-1 align-items-center">
                                        <div class="col-4">
                                            <label for="emp_name">Name </label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="emp_name" name="emp_name" class="form-control" />
                                        </div>
                                        <div class="col-4">
                                            <label for="emp_designation">Designation </label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="emp_designation" name="emp_designation"
                                                class="form-control" />
                                        </div>
                                        <div class="col-4">
                                            <label for="office_name">Office</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" name="office_name" id="office_name"
                                                class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-1 align-items-center p-3">
                        <div class="col-12">
                            <label for="remarks" class="col-form-label">Remarks :</label>
                        </div>
                        <div class="col-12">
                            <textarea type="text" rows="2" class="form-control" id="remarks" name="remarks"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info"> Forward Instance</button>
            </div>
            </form>
        </div>
    </div>
    <div class="card table-responsive">
        <div class="card-body">
            <table id="user_Request_Details" class="table border caption-top">
                <caption class="fs-4">Movement History</caption>
                <thead class="table-dark fw-bold">
                    <tr class="align-middle text-center">
                        <th>#</th>
                        <th>Send By</th>
                        <th>Sent to</th>
                        <th>on Date</th>
                        <th>Remark</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php($count=1)
                    @foreach($instance_history as $receiver)
                    <tr>
                        <td>{{$count}} </td>
                        <td>{{$receiver->sender->name}} ({{$receiver->sender->designation}})
                        </td>
                        <td>{{$receiver->emp_name}} ({{$receiver->designation}})
                        </td>
                        <td>{{$receiver->created_at->format('d / m / Y') }}</td>
                        <td>{{$receiver->remarks}}</td>
                        <td> {{($receiver->action_taken == 0) ? "Moved" : "Forwarded" }} </td>
                    </tr>
                    @php($count++)
                    @endforeach
                </tbody>
            </table>
        </div>        
    </div>
</div>

@endsection

@section('footscripts')

<script type="text/javascript">
    function getEmployeeDesignationWise()
    {
        var designation = $("#designation").val(); 
        var _token = $('input[name="_token"]').val();
        if (designation > 0) {
            $.ajax({
                url: "{{ route('getEmployeeDesignationWise') }}",
                method: "POST",
                data: {
                    designation: designation,
                    _token: _token
                },
                success: function(data) {
                    bindDdlWithData("employees", data, "id", "name", false, "0", "Find employees");
                    $('#employees').val("");
                }
            });
        }
    }
 
</script>

@include('partials.js._dropDownJs')

@include('partials.js._makeDropDown')



<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.js"></script>

<script type="text/javascript">
    var placeholder = "Search Officer";

        $(".select2" ).select2({
            placeholder: placeholder,
            width: 250,
            containerCssClass: 'form-control' 
        });

        $(".select2").on( "select2:open", function() {
            if($( this ).parents( "[class*='has-']" ).length ) {
                var classNames = $( this ).parents( "[class*='has-']" )[ 0 ].className.split( /\s+/ );
                for(var i = 0; i < classNames.length; ++i ) {
                    if ( classNames[ i ].match( "has-" ) ) {
                        $( "body > .select2-container" ).addClass( classNames[ i ] );
                    }
                }
            }
        });

</script>




@endsection
