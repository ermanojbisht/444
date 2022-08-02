@extends('layouts.type200.main')

@section('headscripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@include('layouts._commonpartials.css._select2')
@endsection

@section('pagetitle')
Edit Employee Registration
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
['datas'=> [
['label'=> 'Home','active'=>false, 'route'=> 'employee.home'],
['label'=> 'Index New Created','active'=>true, 'route' => 'employee.index'],
['label'=> 'Create','active'=>true],
]])
@endsection

@section('sidebarmenu')

@endsection

@section('content')

<form action="{{ route('employee.update') }}" method="POST"
    onsubmit="return confirm('Above Written Details are correct to my knowledge. ( मेरे द्वार भरा गया उपरोक्त डाटा सही हैं ) ??? ');">
    @csrf

    <div class="row">
        {{-- Employee Code --}}
        <div class="form-group col-md-3">
            <label class="required" for="id"> Employee Code </label>
            <input class="form-control {{ $errors->has('id') ? 'is-invalid' : '' }}" type="text" minlength="5"
                maxlength="50" name="id" id="id" value="{{ old('id') == '' ? $employee->id : old('id') }}"
                placeholder="Employee Code" required>

            <input type="hidden" id="employee_id" name="employee_id"  value="{{$employee->id}}" />
            @if($errors->has('id'))
            <div class="invalid-feedback">
                {{ $errors->first('id') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>

        {{-- Employee Name --}}
        <div class="form-group col-md-3">
            <label class="required" for="name"> Employee Name </label>
            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" minlength="3"
                maxlength="150" name="name" id="name" value="{{ old('name') == '' ? $employee->name : old('name') }}"
                placeholder="Employee Name" required>
            @if($errors->has('name'))
            <div class="invalid-feedback">
                {{ $errors->first('name') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>


        {{-- Gender --}}
        <div class="form-group col-md-3">
            <label class="required" for="gender_id"> Gender </label>
            {!! Form::select('gender_id', config('hrms.masters.gender'), '1',
            ['id'=>'gender_id', 'required'=>'required',
            'class'=>'form-select ' ]) !!}
            @if($errors->has('gender_id'))
            <div class="invalid-feedback">
                {{ $errors->first('gender_id') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>

        {{-- Date of Birth --}}
        <div class="form-group col-md-3">
            <label class="required" for="birth_date"> Date of Birth </label>
            <input class="form-control {{ $errors->has('birth_date') ? 'is-invalid' : '' }}" type="date"
                name="birth_date" id="birth_date" max="{{ date("Y") - 18}}-01-01"
                value="{{$employee->birth_date ? $employee->birth_date->format('Y-m-d') : old('birth_date', '') }}"
                required format>
            @if($errors->has('birth_date'))
            <div class="invalid-feedback">
                {{ $errors->first('birth_date') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>
    </div>
    <br />


    <div class="row">

        {{-- Appointment Through --}}
        <div class="form-group col-md-3">
            <label class="required" for="appointed_through"> Appointment Through </label>
            {!! Form::select('appointed_through', config('hrms.masters.appointmentType'),
            $employee->appointed_through,
            ['id'=>'appointed_through','class'=>'form-select','required'], ) !!}
            @if($errors->has('appointed_through'))
            <div class="invalid-feedback">
                {{ $errors->first('appointed_through') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>

        {{-- appointment_order_no --}}
        <div class="form-group col-md-3">
            <label class="" for="appointment_order_no"> Order No </label>
            <input type="text" class="form-control" id="appointment_order_no" name="appointment_order_no"
                placeholder="Order No" value="{{$employee->appointment_order_no}}" />
            @if($errors->has('appointment_order_no'))
            <div class="invalid-feedback">
                {{ $errors->first('appointment_order_no') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>


        {{-- Order Date --}}
        <div class="form-group col-md-3">
            <label class="required" for="appointment_order_at"> Order Date </label>
            <input class="form-control {{ $errors->has('appointment_order_at') ? 'is-invalid' : '' }}" type="date"
                name="appointment_order_at" id="appointment_order_at" max="{{ date("Y-m-d")}}"
                value="{{$employee->appointment_order_at ? $employee->appointment_order_at->format('Y-m-d') : old('appointment_order_at', '') }}"
                required format>
            @if($errors->has('appointment_order_at'))
            <div class="invalid-feedback">
                {{ $errors->first('appointment_order_at') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>

        {{-- designation_id --}}
        <div class="form-group col-md-3">
            <label class="required" for="designation_id"> Designation </label>
            {!! Form::select('designation_id', $designations, $employee->designation_id,
            ['id' => 'designation_id', 'class'=>'form-select select2', 'required']) !!}
            @if($errors->has('designation_id'))
            <div class="invalid-feedback">
                {{ $errors->first('designation_id') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>

        
    </div>

    <br />
    <div class="row">

        {{-- office_idd --}}
        <div class="form-group col-md-3">
            <label class="required" for="office_idd"> Office </label>
            {!! Form::select('office_idd', $offices, $employee->office_idd,
            ['id' => 'office_idd', 'class'=>'form-select select2', 'required']) !!}
            @if($errors->has('office_idd'))
            <div class="invalid-feedback">
                {{ $errors->first('office_idd') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>

        {{-- Date of Joining --}}
        <div class="form-group col-md-3">
            <label class="required" for="joining_date"> Date of Joining </label>
            <input class="form-control {{ $errors->has('joining_date') ? 'is-invalid' : '' }}" type="date"
                name="joining_date" id="joining_date" max="{{ date("Y-m-d")}}"
                value="{{$employee->joining_date ? $employee->joining_date->format('Y-m-d') : old('retirement_date', '') }}"
                required format>
            @if($errors->has('joining_date'))
            <div class="invalid-feedback">
                {{ $errors->first('joining_date') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>


        <div class="col-md-3">
            <div class="form-group">
                <br />
                <div class="box-footer justify-content-between">
                    {!! Form::hidden('regular_incharge', '0', ['id'=>'regular_incharge']) !!}
                    {!! Form::hidden('lock_level', '0', ['id'=>'lock_level']) !!}
                    <button id="btnAddRegDetails" type="submit" class="btn btn-success">
                        Update Employee Detail </button>
                </div>
            </div>
        </div>
    </div>
    <br />
</form>

@endsection

@section('footscripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(".select2").select2(); 
</script>
@include('partials.js._makeDropDown')
@endsection