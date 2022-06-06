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
                    <input class="form-control {{ $errors->has('id') ? 'is-invalid' : '' }}" type="text" minlength="3"
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
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" minlength="3"
                        maxlength="150" name="name" id="name" value="{{ old('name', '') }}" placeholder="Employee Name"
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
                        name="birth_date" id="birth_date" value="{{ old('birth_date', '') }}" required format>
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

                {{-- Order Date --}}
                <div class="form-group col-md-3">
                    <label class="required" for="transfer_order_date"> Order Date </label>
                    <input class="form-control {{ $errors->has('transfer_order_date') ? 'is-invalid' : '' }}"
                        type="date" name="transfer_order_date" id="transfer_order_date"
                        value="{{  old('transfer_order_date', '') }}" required format>
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
                    {!! Form::select('current_designation_id', $designations, '1', ['id' => 'current_designation_id',
                    'class'=>'form-select select2', 'required']) !!}
                    @if($errors->has('current_designation_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('current_designation_id') }}
                    </div>
                    @endif
                    <span class="help-block"> </span>
                </div>

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

                <br />
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