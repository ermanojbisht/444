@extends('layouts.type200.main')

@section('headscripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@include('layouts._commonpartials.css._select2')
@endsection


@section('pagetitle')
{{ $title }}
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
['datas'=> [
['label'=> 'Home','active'=>false, 'route'=> 'employee.home'],
['label'=> 'Update Employee Office and Designation','active'=>true],
]])
@endsection

@section('sidebarmenu')
    @include('layouts.type200._commonpartials._sidebarmenu_hrms',['active'=>'Employees'])
@endsection

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('employee.updateEmployePostings') }}" method="POST"
            onsubmit="return confirm('Above Written Details are correct to my knowledge. ( मेरे द्वार भरा गया उपरोक्त डाटा सही हैं ) ??? ');">
            @csrf

            <div class="row">


                {{-- designation_id --}}
                <div class="form-group col-md-3">
                    <label class="required" for="designation_id"> Designation </label>
                    {!! Form::select('designation_id', $designations, '1', ['id' => 'designation_id',
                    'class'=>'form-select select2', 'required', 'onchange'=>'getEmployeeByDesignation(this)']) !!}
                    @if($errors->has('designation_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('designation_id') }}
                    </div>
                    @endif
                    <span class="help-block"> </span>
                </div>


                {{-- Employee Code --}}
                <div class="form-group col-md-3">
                    <label class="required" for="id"> Select Employee </label>
                    <select class="form-select select2 {{ $errors->has('id') ? 'is-invalid' : '' }}" name="id" id="id"
                        required>
                    </select>
                    @if($errors->has('id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('id') }}
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


                {{-- transfer_order_date --}}
                <div class="form-group col-md-3">
                    <label class="required" for="transfer_order_date"> Order Date </label>
                    <input class="form-control {{ $errors->has('transfer_order_date') ? 'is-invalid' : '' }}"
                        type="date" name="transfer_order_date" id="transfer_order_date" max="{{ date(" Y-m-d")}}"
                        value="{{  old('transfer_order_date', '') }}" required format>
                    @if($errors->has('transfer_order_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('transfer_order_date') }}
                    </div>
                    @endif
                    <span class="help-block"> </span>
                </div>


                



            </div>
            <br />

            <div class="row">

                {{-- is_office_head --}}
                <div class="form-group col-md-3">
                    <label class="is_office_head required" for="to_date"> Is Office Head </label>
                    <br />
                    {!! Form::radio('is_office_head', '1', '',
                    ['id' => 'is_office_head_Yes', 'class'=>'radio ', 'required']) !!}

                    {!! Form::label('is_office_head_Yes', 'Is Office Head', ['class'=>'label']) !!}

                    <br />
                    {!! Form::radio('is_office_head', '0', '',
                    ['id' => 'is_office_head_No', 'class'=>'radio ', 'required']) !!}
                    {!! Form::label('is_office_head_No', 'Is Not office Head', ['class'=>'label']) !!}

                    @if($errors->has('is_office_head'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_office_head') }}
                    </div>
                    @endif
                    <span class="help-block"> </span>
                </div>

                {{-- is_designation_changed --}}
                <div class="form-group col-md-3">
                    <label class="is_designation_changed required" for="to_date"> Is Designation Changed </label>
                    <br />
                    {!! Form::radio('is_designation_changed', '1', '',
                    ['id' => 'is_designation_changed_Yes', 'class'=>'radio ', 'required',
                    'onchange'=>'isDesignationChanged(1)']) !!}

                    {!! Form::label('is_designation_changed_Yes', 'Is Designation Changed', ['class'=>'label']) !!}

                    <br />
                    {!! Form::radio('is_designation_changed', '0', '',
                    ['id' => 'is_designation_changed_No', 'class'=>'radio ',
                    'required','onchange'=>'isDesignationChanged(0)']) !!}
                    {!! Form::label('is_designation_changed_No', 'Designation Not Changed', ['class'=>'label']) !!}

                    @if($errors->has('is_designation_changed'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_designation_changed') }}
                    </div>
                    @endif
                    <span class="help-block"> </span>
                </div>

                {{-- regular_incharge --}}
                <div class="form-group col-md-3 is_incharge " style="display:none;">
                    <label class=" required" for="to_date"> Is Regular / Incharge </label>
                    <br />
                    {!! Form::radio('regular_incharge', '1', '',
                    ['id' => 'regular', 'class'=>'radio ']) !!}

                    {!! Form::label('regular', 'Is Regular', ['class'=>'label']) !!}
                    <br />
                    {!! Form::radio('regular_incharge', '0', '',
                    ['id' => 'incharge', 'class'=>'radio ']) !!}
                    {!! Form::label('incharge', 'Incharge', ['class'=>'label']) !!}

                    @if($errors->has('regular_incharge'))
                    <div class="invalid-feedback">
                        {{ $errors->first('regular_incharge') }}
                    </div>
                    @endif
                    <span class="help-block"> </span>
                </div>
                
                

                {{-- current_designation_id --}}
                <div class="form-group col-md-3">
                    <label class="required" for="current_designation_id"> Current Designation </label>
                    <br />
                    {!! Form::select('current_designation_id', $designations, "1", ['id' => 'current_designation_id',
                    'class'=>'form-select select2', 'required' ]) !!}
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

                {{-- is_office_changed --}}
                <div class="form-group col-md-3">
                    <label class="is_office_changed required" for="to_date"> Is Office Changed </label>
                    <br />
                    {!! Form::radio('is_office_changed', '1', '',
                    ['id' => 'is_office_changed_Yes', 'class'=>'radio ', 'required',
                    'onchange'=>'isOfficeChanged(1)']) !!}
                    {!! Form::label('is_office_changed_Yes', 'Is Office Changed', ['class'=>'label']) !!}

                    <br />
                    {!! Form::radio('is_office_changed', '0', '',
                    ['id' => 'is_office_changed_No', 'class'=>'radio ', 'required',
                   'onchange'=>'isOfficeChanged(0)']) !!}
                    {!! Form::label('is_office_changed_No', 'Office Not Changed', ['class'=>'label']) !!}

                    @if($errors->has('is_office_changed'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_office_changed') }}
                    </div>
                    @endif
                    <span class="help-block"> </span>
                </div>


                {{-- current_office_id --}}
                <div class="form-group col-md-3 change_office" style="display:none;">
                    <label class="required" for="current_office_id"> Office </label>
                    <br />
                    {!! Form::select('current_office_id', $offices, '', ['id' => 'current_office_id',
                    'class'=>'form-select select2','style'=>'width:100%']) !!}
                    @if($errors->has('current_office_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('current_office_id') }}
                    </div>
                    @endif
                    <span class="help-block"> </span>
                </div>

                <div class="form-group col-md-3 justify-content-center ">
                    <br />
                     
                    {!! Form::hidden('informed_by_employee_id', Auth::user()->employee_id, ['id'=>'informed_by_employee_id']) !!}

                    <button id="btnAddRegDetails" type="submit" class="btn btn-success">
                        Save Employee Detail </button>
                </div>
            </div>
        </form>

    </div>

</div>

@endsection

@section('footscripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(".select2").select2();

    function getEmployeeByDesignation(designation)
    {
        var designation_id =  $("#" +designation.id).val();
        let _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('employee.getEmployeesDesignationWise') }}",
            method: "POST",
            data: {
                designation_id : designation_id,
                _token : _token
            },
            success: function (data) {
               if(data == "") {
                    //alert("no data"); 
                }
                else{
                    bindDdlWithData("id", data, "id", "name", true, "", "Select Employee");
                    
                }
            }
        });
        $("#current_designation_id").val(designation_id).trigger('change');
        $('#current_designation_id').select2("enable",false);
    }


    function isDesignationChanged(ischanged)
    {
        if(ischanged == 1){
            $('#current_designation_id').select2("enable");
            $("#current_designation_id").val("").trigger('change');
            $('.is_incharge').css("display","inline-block");  
            
            $("#regular").attr('required','required');
            $("#incharge").attr('required','required');
        }
        else{        
            $('#current_designation_id').select2("enable",false);
            var designation_id =  $("#designation_id").val();
            $("#current_designation_id").val(designation_id).trigger('change');
            $('.is_incharge').css("display","none"); 

            $("#regular").removeAttr('required');
            $("#incharge").removeAttr('required');

        }
    }

    function isOfficeChanged(ischanged)
    {
        if(ischanged == 1){
            $('.change_office').css("display","inline-block");  
            $("#current_office_id").attr('required','required');
        }
        else{ 
            $('.change_office').css("display","none");
            $("#current_office_id").removeAttr('required');
        }

    }
     

</script>
@include('partials.js._makeDropDown')
@endsection