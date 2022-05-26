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
            <input class="form-control {{ $errors->has('id') ? 'is-invalid' : '' }}" type="text" minlength="3"
                maxlength="50" name="id" id="id" value="{{ old('id') == '' ? $employee->id : old('id') }}"
                placeholder="Employee Code" required>
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

        {{-- Father's / Husband Name --}}
        <div class="form-group col-md-3">
            <label class="required" for="father_name"> Father's / Husband Name </label>
            <input class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}" type="text" minlength="3"
                maxlength="150" name="father_name" id="father_name"
                value="{{ old('father_name') == '' ? $employee->father_name : old('father_name') }}"
                placeholder="Father's / Husband Name" required>
            @if($errors->has('father_name'))
            <div class="invalid-feedback">
                {{ $errors->first('father_name') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>

        {{-- Gender --}}
        <div class="form-group col-md-3">
            <label class="required" for="gender_id"> Gender </label>
            {!! Form::select('gender_id', config('hrms.masters.gender'), $employee->gender_id,
            ['id'=>'gender_id', 'required'=>'required',
            'class'=>'form-select ' ]) !!}
            @if($errors->has('gender_id'))
            <div class="invalid-feedback">
                {{ $errors->first('gender_id') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>
    </div>

    <br />
    <div class="row">
        {{-- Date of Birth --}}
        <div class="form-group col-md-3">
            <label class="required" for="birth_date"> Date of Birth </label>
            <input class="form-control {{ $errors->has('birth_date') ? 'is-invalid' : '' }}" type="date"
                name="birth_date" id="birth_date"
                value="{{$employee->birth_date ? $employee->birth_date->format('Y-m-d') : old('birth_date', '') }}"
                required format>
            @if($errors->has('birth_date'))
            <div class="invalid-feedback">
                {{ $errors->first('birth_date') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>

        {{-- Date of Retirement --}}
        <div class="form-group col-md-3">
            <label class="required" for="retirement_date"> Date of Retirement </label>
            <input class="form-control {{ $errors->has('retirement_date') ? 'is-invalid' : '' }}" type="date"
                name="retirement_date" id="retirement_date"
                value="{{$employee->retirement_date ? $employee->retirement_date->format('Y-m-d') : old('retirement_date', '') }}"
                required format>
            @if($errors->has('retirement_date'))
            <div class="invalid-feedback">
                {{ $errors->first('retirement_date') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>

        {{-- Mobile No --}}
        <div class="form-group col-md-3">
            <label class="required" for="phone_no"> Mobile No</label>
            <input class="form-control {{ $errors->has('phone_no') ? 'is-invalid' : '' }}" type="text" minlength="10"
                maxlength="10" name="phone_no" id="phone_no"
                value="{{ old('phone_no') == '' ? $employee->phone_no : old('phone_no') }}" placeholder="Mobile No"
                required>
            @if($errors->has('phone_no'))
            <div class="invalid-feedback">
                {{ $errors->first('phone_no') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>

        {{-- Alternate Mobile No --}}
        <div class="form-group col-md-3">
            <label for="phone_no1"> Alternate Mobile No</label>
            <input class="form-control {{ $errors->has('phone_no1') ? 'is-invalid' : '' }}" type="text" minlength="10"
                maxlength="10" name="phone_no1" id="phone_no1"
                value="{{ old('phone_no1') == '' ? $employee->phone_no1 : old('phone_no1') }}"
                placeholder="Alternate Mobile No">
            @if($errors->has('phone_no1'))
            <div class="invalid-feedback">
                {{ $errors->first('phone_no1') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>
    </div>
    <br />

    <div class="row">

        {{-- Email Address --}}
        <div class="form-group col-md-3">
            <label class="required" for="email"> Email Address </label>
            <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" minlength="5"
                maxlength="100" name="email" id="email"
                value="{{ old('email') == '' ? $employee->email : old('email') }}" placeholder="Alternate Mobile No"
                required>
            @if($errors->has('email'))
            <div class="invalid-feedback">
                {{ $errors->first('email') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>

        {{-- Pan --}}
        <div class="form-group col-md-3">
            <label class="required" for="pan"> Pan </label>
            <input class="form-control {{ $errors->has('pan') ? 'is-invalid' : '' }}" type="text" minlength="5"
                maxlength="10" name="pan" id="pan" value="{{ old('pan') == '' ? $employee->pan : old('pan') }}"
                placeholder="Pan Card Number" required>
            @if($errors->has('pan'))
            <div class="invalid-feedback">
                {{ $errors->first('pan') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>

        {{-- Aadhar --}}
        <div class="form-group col-md-3">
            <label class="required" for="aadhar"> Aadhar </label>
            <input class="form-control {{ $errors->has('aadhar') ? 'is-invalid' : '' }}" type="text" minlength="12"
                maxlength="12" name="aadhar" id="aadhar"
                value="{{ old('aadhar') == '' ? $employee->aadhar : old('aadhar') }}" placeholder="Aadhar Card Number"
                required>
            @if($errors->has('aadhar'))
            <div class="invalid-feedback">
                {{ $errors->first('aadhar') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>

        {{-- Blood Group --}}
        <div class="form-group col-md-3">
            <label class="required" for="blood_group_id"> Blood Group </label>
            {!! Form::select('blood_group_id', config('hrms.masters.bloodGroup'), $employee->blood_group_id,
            ['id'=>'blood_group_id','class'=>'form-select','required'], ) !!}
            @if($errors->has('blood_group_id'))
            <div class="invalid-feedback">
                {{ $errors->first('blood_group_id') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>


    </div>
    <br />
    <div class="row">

        {{-- Martial Status --}}
        <div class="form-group col-md-3">
            <label class="required" for="is_married"> Martial Status </label>
            {!! Form::select('is_married', config('hrms.masters.married'), $employee->is_married,
            ['id'=>'is_married','class'=>'form-select','required'], ) !!}
            @if($errors->has('is_married'))
            <div class="invalid-feedback">
                {{ $errors->first('is_married') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>

        {{-- Cast Category --}}
        <div class="form-group col-md-3">
            <label class="required" for="cast_id"> Category </label>
            {!! Form::select('cast_id', config('hrms.masters.cast'), $employee->cast_id,
            ['id'=>'cast_id','class'=>'form-select','required'], ) !!}
            @if($errors->has('cast_id'))
            <div class="invalid-feedback">
                {{ $errors->first('cast_id') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>

        {{-- Sub - Category --}}
        <div class="form-group col-md-3">
            <label class="required" for="benifit_category_id"> Sub-Category </label>
            {!! Form::select('benifit_category_id', config('hrms.masters.disability'), $employee->benifit_category_id,
            ['id'=>'benifit_category_id','class'=>'form-select', 'required'], ) !!}
            @if($errors->has('benifit_category_id'))
            <div class="invalid-feedback">
                {{ $errors->first('benifit_category_id') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>

        {{-- Religion --}}
        <div class="form-group col-md-3">
            <label class="required" for="religion_id"> Religion </label>
            {!! Form::select('religion_id', config('hrms.masters.religion'), $employee->religion_id,
            ['id'=>'religion_id','class'=>'form-select', 'required' ] ) !!}
            @if($errors->has('religion_id'))
            <div class="invalid-feedback">
                {{ $errors->first('religion_id') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>
    </div>

    <br />
    <div class="row">

        {{-- Height --}}
        <div class="form-group col-md-3">
            <label class="required" for="aadhar"> Height (in Centimeters) </label>
            <input class="form-control {{ $errors->has('height') ? 'is-invalid' : '' }}" type="number" minlength="2"
                maxlength="3" name="height" id="height"
                value="{{ old('height') == '' ? $employee->height : old('height') }}"
                placeholder="Enter Height in centi meters" required>
            @if($errors->has('height'))
            <div class="invalid-feedback">
                {{ $errors->first('height') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>

        {{-- Identity Mark --}}
        <div class="form-group col-md-3">
            <label class="required" for="aadhar"> Identity Mark </label>
            <input class="form-control {{ $errors->has('identity_mark') ? 'is-invalid' : '' }}" type="text"
                minlength="5" maxlength="150" name="identity_mark" id="identity_mark"
                value="{{ old('identity_mark') == '' ? $employee->identity_mark : old('identity_mark') }}"
                placeholder="Enter Visible Identity Mark " required>
            @if($errors->has('identity_mark'))
            <div class="invalid-feedback">
                {{ $errors->first('identity_mark') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>

        {{-- Order Date --}}
        <div class="form-group col-md-3">
            <label class="required" for="transfer_order_date"> Order Date </label>
            <input class="form-control {{ $errors->has('transfer_order_date') ? 'is-invalid' : '' }}" type="date"
                name="transfer_order_date" id="transfer_order_date"
                value="{{$employee->transfer_order_date ? $employee->transfer_order_date->format('Y-m-d') : old('transfer_order_date', '') }}"
                required format>
            @if($errors->has('transfer_order_date'))
            <div class="invalid-feedback">
                {{ $errors->first('transfer_order_date') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>

        {{-- current_designation_id --}}
        <div class="form-group col-md-3">
            <label class="required" for="current_designation_id"> Designation </label>
            {!! Form::select('current_designation_id', $designations,  $employee->current_designation_id, 
            ['id' => 'current_designation_id', 'class'=>'form-select select2', 'required']) !!}
            @if($errors->has('current_designation_id'))
            <div class="invalid-feedback">
                {{ $errors->first('current_designation_id') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>

    </div>

    <br/>
    <div class="row">
        {{-- current_office_id --}}
        <div class="form-group col-md-3">
            <label class="required" for="current_office_id"> Office </label>
            {!! Form::select('current_office_id', $offices, $employee->current_office_id, 
            ['id' => 'current_office_id', 'class'=>'form-select select2', 'required']) !!}
            @if($errors->has('current_office_id'))
            <div class="invalid-feedback">
                {{ $errors->first('current_office_id') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div>

        {{-- Is Office Head --}}
        {{-- <div class="form-group col-md-3">
            <label class="required" for="is_office_head"> Is Office Head </label>
            <br />
            {!! Form::radio('is_office_head', '1', false, ['id'=>'is_office_head_Yes', 'required']) !!}
            {!! Form::label('is_office_head_Yes', 'Office Head', ['class'=>'form-label']) !!} <br />

            {!! Form::radio('is_office_head', '0', true, ['id'=>'is_office_head_No', 'required']) !!}
            {!! Form::label('is_office_head_No', 'Not Office Head', ['class'=>'form-label']) !!}
            @if($errors->has('is_office_head'))
            <div class="invalid-feedback">
                {{ $errors->first('is_office_head') }}
            </div>
            @endif
            <span class="help-block"> </span>
        </div> --}}
    </div>

    <br />
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <br />
                <div class="box-footer justify-content-between">
                    <input type="hidden" id="lock_level" name="lock_level" value="0" />
                    <button id="btnAddRegDetails" type="submit" class="btn btn-success">
                        Save Employee Detail </button>
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

    // function countCharacters(thiss, lblShowCounterId)
    // {
    //     $("#" +lblShowCounterId).html(thiss.value.length);
    // }
</script>
@include('partials.js._makeDropDown')
@endsection