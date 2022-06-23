@extends('layouts.type200.main')

@section('headscripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@include('layouts._commonpartials.css._select2')
@endsection


@section('pagetitle')
Employee Registration
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
['datas'=> [
['label'=> 'Home','active'=>false, 'route'=> 'employee.home'],
['label'=> 'New Created Employees','active'=>true, 'route' => 'employee.index'],
['label'=> 'Create','active'=>true],
]])
@endsection

@section('sidebarmenu')

@endsection

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('employee.store') }}" method="POST"
            onsubmit="return confirm('Above Written Details are correct to my knowledge. ( मेरे द्वार भरा गया उपरोक्त डाटा सही हैं ) ??? ');">
            @csrf

            <div class="row">

                {{-- Employee Code --}}
                <div class="form-group col-md-3">
                    <label class="required" for="id"> Employee Code </label>
                    <input class="form-control {{ $errors->has('id') ? 'is-invalid' : '' }}" type="text" minlength="5"
                        maxlength="50" name="id" id="id" value="{{ old('id', '') }}" placeholder="Employee Code"
                        required>
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
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" minlength=3
                        maxlength=150 name="name" id="name" value="{{ old('name', '') }}" placeholder="Employee Name"
                        required>
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
                        max="{{ date(" Y") - 18}}-01-01" name="birth_date" id="birth_date"
                        value="{{ old('birth_date', '') }}" required format>
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
                    {!! Form::select('appointed_through', config('hrms.masters.appointmentType'), 1,
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
                        placeholder="Order No" />
                    @if($errors->has('appointment_order_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('appointment_order_no') }}
                    </div>
                    @endif
                    <span class="help-block"> </span>
                </div>

                {{-- appointment_order_at --}}
                <div class="form-group col-md-3">
                    <label class="required" for="appointment_order_at"> Order Date </label>
                    <input class="form-control {{ $errors->has('appointment_order_at') ? 'is-invalid' : '' }}"
                        type="date" name="appointment_order_at" id="appointment_order_at" max="{{ date(" Y-m-d")}}"
                        value="{{  old('appointment_order_at', '') }}" required format>
                    @if($errors->has('appointment_order_at'))
                    <div class="invalid-feedback">
                        {{ $errors->first('appointment_order_at') }}
                    </div>
                    @endif
                    <span class="help-block"> </span>
                </div>

                {{-- current_designation_id --}}
                <div class="form-group col-md-3">
                    <label class="required" for="current_designation_id"> Designation </label>
                    {!! Form::select('current_designation_id', $designations, '1', ['id' => 'current_designation_id',
                    'class'=>'form-select select2', 'required']) !!}
                    @if($errors->has('current_designation_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('current_designation_id') }}
                    </div>
                    @endif
                    <span class="help-block"> </span>
                </div>


            </div>
            <br />
            <div class="row">

                {{-- current_office_id --}}
                <div class="form-group col-md-3">
                    <label class="required" for="current_office_id"> Office </label>
                    {!! Form::select('current_office_id', $offices, '', ['id' => 'current_office_id',
                    'class'=>'form-select select2', 'required']) !!}
                    @if($errors->has('current_office_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('current_office_id') }}
                    </div>
                    @endif
                    <span class="help-block"> </span>
                </div>

                {{-- Date of Joining --}}
                <div class="form-group col-md-3">
                    <label class="required" for="joining_date"> Date of Joining </label>
                    <input class="form-control {{ $errors->has('joining_date') ? 'is-invalid' : '' }}" type="date"
                        name="joining_date" id="joining_date" value="{{old('joining_date', '') }}" max="{{ date("
                        Y-m-d")}}" required format>
                    @if($errors->has('joining_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('joining_date') }}
                    </div>
                    @endif
                    <span class="help-block"> </span>
                </div>

                <div class="form-group col-md-3 justify-content-center ">
                    <br />
                    <input type="hidden" id="lock_level" name="lock_level" value="0" />
                    <button id="btnAddRegDetails" type="submit" class="btn btn-success">
                        Save Employee Detail </button>
                </div>
            </div>
            <br />
        </form>

    </div>

</div>

@endsection

@section('footscripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(".select2").select2();

    // function countCharacters(thiss, lblShowCounterId)
    // {
    //     $("#" +lblShowCounterId).html(thiss.value.length);
    // }
</script>
@include('partials.js._makeDropDown')
@endsection