@extends('layouts.type200.main')

@section('headscripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@include('layouts._commonpartials.css._select2')
@endsection


@section('pagetitle')
{{($isLastPostingClosed) ? 'Add New Postings' : 'Enter End Date of Current Posting ' }}
for Employee {{$employee->name}} ({{$employee->id}})
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
['datas'=> [
['label'=> 'Home','active'=>false, 'route'=> 'employee.home'],
['label'=> 'Office Employees','active'=>true, 'route' => 'employee.office.index'],
['label'=> 'View Employee','active'=>true, 'route' => 'employee.office.view','routefielddata' => $employee->id],
['label'=> 'Add New Postings','active'=>true],
]])
@endsection

@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_hrms',['active'=>'Employees'])
@endsection

@section('content')

@if($isLastPostingClosed)

<form action="{{ route('employee.postings.store') }}" method="POST"
    onsubmit="return confirm('Above Written Details are correct to my knowledge. ( मेरे द्वार भरा गया उपरोक्त डाटा सही हैं ) ??? ');">
    @csrf

    <div class="row">

        <div class="form-group  col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        {{-- designation_id --}}
                        <div class="form-group col-md-3">
                            <label class="" for="designation_id"> Current Designation </label>
                            <br />
                            @if($employee->designation_id)
                            {!! Form::label('', $designations[$employee->designation_id],
                            ['class'=>'label']) !!}
                            <span>@if($employee->regular_incharge == 1) (Incharge) @endif</span>
                            @else
                            Not delclared by Section
                            @endif
                            {!! Form::hidden('regular_incharge', $employee->regular_incharge,
                            ['id'=>'regular_incharge'])
                            !!}
                            {!! Form::hidden('designation_id', $employee->designation_id,
                            ['id'=>'designation_id']) !!}


                            @if($errors->has('designation_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('designation_id') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>

                        {{-- office_id --}}
                        <div class="form-group col-md-3">
                            <label class="" for="office_id"> Current Office </label>
                            <br />
                            {!! Form::label('', $offices[$employee->office_idd], ['class'=>'label']) !!}
                            {!! Form::hidden('office_id', $employee->office->id, ['id'=>'office_id']) !!}
                            @if($errors->has('office_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('office_id') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>

                        {{-- order_no --}}
                        <div class="form-group col-md-3">
                            <label class="" for="order_no"> Order No </label>
                            <input type="text" class="form-control" id="order_no" name="order_no"
                                placeholder="Order No" />
                            @if($errors->has('order_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('order_no') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>

                        {{-- Order Date --}}
                        <div class="form-group col-md-3">
                            <label class="" for="order_at"> Order Date </label>
                            <input class="form-control {{ $errors->has('order_at') ? 'is-invalid' : '' }}" type="date"
                                name="order_at" id="order_at" format
                                value="{{$employee->order_at ? $employee->order_at->format('Y-m-d') : old('order_at', '') }} ">
                            @if($errors->has('order_at'))
                            <div class="invalid-feedback">
                                {{ $errors->first('order_at') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        {{-- Mode --}}
                        <div class="form-group col-md-3">
                            <label class="required" for="mode_id"> Mode </label>
                            {!! Form::select('mode_id', config('hrms.masters.historyType'), '1',
                            ['id'=>'mode_id', 'required'=>'required', 'class'=>'form-select ' ]) !!}
                            @if($errors->has('mode_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('mode_id') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>

                        {{-- From Date --}}
                        <div class="form-group col-md-3">
                            <label class="required" for="from_date"> From Date </label>
                            <input class="form-control {{ $errors->has('from_date') ? 'is-invalid' : '' }}" type="date"
                                name="from_date" id="from_date" format required value="{{ old('from_date', '')}}">
                            @if($errors->has('from_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('from_date') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>

                        <div class="form-group col-md-3">
                            <br />
                            {!! Form::hidden('updated_by', Auth::user()->employee_id, ['id'=>'updated_by',
                            'class'=>'form-control', 'required']) !!}
                            <div class="box-footer justify-content-between">
                                <button id="btnAddRegDetails" type="submit" class="btn btn-success">
                                    Add Posting Detail </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br />
</form>
@endif

<div class="card">
    <div class="card-body text-info">

        <p class="h5"> Employee Posting Details in Reverse Order : </p>
        <div class="row">
            <div class="form-group col-md-12">
                <table id="tbl_employee_postings" class="table border mb-0 dataTable no-footer ">
                    <tr>
                        <th>
                            Office
                        </th>
                        <th>
                            Designation
                        </th>
                        <th>
                            From Date
                        </th>
                        <th>
                            To Date
                        </th>
                        <th>
                            Days
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                    @foreach($employeePostings as $posting )
                    <tr>
                        <td>
                            <span id="lbloffice{{$posting->id}}"> {{ $posting->postingOffice->name }} </span>
                        </td>
                        <td>
                            @if ($posting->designation_id)
                            <label id="lbldesignation{{$posting->id}}"> {{ $posting->designation->name }} </label>
                            <label style="display: none;" id="lbldesignationid{{$posting->id}}"> {{
                                $posting->designation->id }} </label>
                            @endif
                        </td>
                        <td>
                            {{$posting->from_date->format('d M Y')}}
                        </td>
                        <td>
                            @if($posting->to_date)
                            {{ $posting->to_date->format('d M Y') }}
                            @else
                            Till Present
                            @endif
                        </td>
                        <td>
                            @if($posting->s_d || $posting->d_d)
                            @if($posting->s_d)
                            {{ $posting->s_d }} Days Sugam
                            @endif

                            @if ($posting->d_d)
                            {{ $posting->s_d }} Days Durgam
                            @endif
                            @else
                            @if($posting->to_date)
                            {{ 1 +
                            (int)(Carbon\Carbon::parse($posting->from_date)->diffInDays(Carbon\Carbon::parse($posting->to_date)))
                            }}
                            @else
                            {{ 1 +
                            (int)Carbon\Carbon::parse('2022-05-31')->diffInDays(Carbon\Carbon::parse($posting->from_date))
                            }}
                            Till 31/05/22
                            @endif
                            @endif
                            {{-- {!! $posting->days_in_office ?
                            $posting->days_in_office . ' Days ' : ' Till Present ' !!} --}}
                        </td>
                        <td>

                            <a class="dropdown-item" target="_blank"
                                href="{{ route('employee.editPosting',['posting'=>$posting->id]) }}">
                                Edit </a>


                            <a class="dropdown-item" target="_blank"
                                href="{{ route('employee.delete',['posting'=>$posting->id]) }}">
                                Delete </a>



                            @if(! $posting->to_date)
                            <a href="javascript:void(0)" onclick="showModal({{$posting->id}})">
                                Add End Date
                            </a>
                            @endif
                        </td>

                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

<!-- boostrap model -->
<div class="modal fade" id="user_data_model" aria-hidden="true" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="width: auto; " role="document">
        <div class="modal-content">
            <div class="modal-body border border-2 border-info p-1 " id="user_input_data">

                <form action="{{ route('employee.postings.updateRelieving') }}" method="POST"
                    onsubmit="return confirm('Above Written Details are correct to my knowledge. ( मेरे द्वार भरा गया उपरोक्त डाटा सही हैं ) ??? ');">
                    @csrf

                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold"> Employee Code :</span>
                            <span> {{$employee->id }}</span>

                            <input class="form-control" type="hidden" name="employee_id" id="employee_id"
                                value="{{ $employee->id == '' ? '' : $employee->id }}">
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold"> Name :</span>
                            <span> {{$employee->name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold"> Designation :</span>
                            <span id="lbldesignation"> </span>
                            <span style="display: none;" id="lbldesignationid"> </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold"> Office :</span>
                            <span id="lbloffice"> </span>
                            <span style="display: none;" id="lblofficeid"> </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <label class="required fw-bold" for="to_date">Last Office Relieving Date </label>
                            {{-- Relieving Date --}}
                            <div class="form-group col-md-6">
                                <input class="form-control {{ $errors->has('to_date') ? 'is-invalid' : '' }}"
                                    type="date" name="to_date" id="to_date" format required
                                    value="{{$employee->to_date ? $employee->to_date->format('Y-m-d') : old('to_date', '') }}">
                                @if($errors->has('to_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('to_date') }}
                                </div>
                                @endif
                                <span class="help-block"> </span>
                            </div>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <div class="form-group col-ofset-6 col-md-6">
                                {!! Form::hidden('updated_by', Auth::user()->employee_id, ['id'=>'updated_by',
                                'class'=>'form-control', 'required']) !!}
                                {!! Form::text('id', "0", ['id'=>'posting_id','style'=>'display:none;']) !!}
                            </div>
                            <div class="form-group col-ofset-6 col-md-6">
                                <input type="submit" class="btn btn-sm btn-success" value="Update Relieving" />
                            </div>
                        </li>

                    </ul>
                    <div class="row">
                    </div>
                    <br />
                </form>

            </div>
        </div>
    </div>
</div>
<!-- end bootstrap model -->



@endsection

@section('footscripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(".select2").select2();

    function showModal(posting)
    {
        $("#lbldesignation").html($("#lbldesignation" +posting).html());
        $("#lbldesignationid").html($("#lbldesignationid" +posting).html());

        $("#lbloffice").html($("#lbloffice" +posting).html());
        $("#lblofficeid").html($("#lblofficeid" +posting).html());

        $("#posting_id").val(posting);


        $('#user_data_model').modal('show');

    }
</script>
@include('partials.js._makeDropDown')
@endsection