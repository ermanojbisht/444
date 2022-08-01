@extends('layouts.type200.main')

@section('headscripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@include('layouts._commonpartials.css._select2')

<script type="text/javascript">
    function same_as_correspond_address()
    {
        if ($('#same_address').is(':checked')){

            $("#address1").html($("#lbl_address1").html());
            $("#address2").html($("#lbl_address2").html());

            var state_id = $("#lbl_state_id").html();
            if(state_id == 5)
            {    
                $("#state_id").val(5).trigger('change');
                $(".addStatedetails").css("display","inline-block");

                var district = $("#lbl_district_id").html();
                $("#district_id").val(district).trigger('change');
 
                $("#tehsil_id").val($("#lbl_tehsil_id").html()).trigger('change');

                var vidhansabha =  $("#lbl_constituency_id").html(); 
                $("#vidhansabha_id").val(vidhansabha).trigger('change');
            }
            
        }else{

            $("#address1").html("");
            $("#address2").html("");
            $("#state_id").val(5).trigger('change');
            $(".addStatedetails").css("display","inline-block");


            $("#district_id").val(1).trigger('change');
            $("#tehsil_id").val(1).trigger('change');
            $("#vidhansabha_id").val(1).trigger('change');


             
        }
    }
    

    function fillOtherDetails()
    {
        var state_id = $("#state_id").val();
        if(state_id != 5)
        {
            $(".addStatedetails").css("display","none");
            $(".forUk").removeAttr("required");

        }else {
            $(".addStatedetails").css("display","inline-block");
            
            $(".forUk").attr("required","required");
            
        }

    }
</script>

@endsection


@section('pagetitle')
Add Employee Address
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
['datas'=> [
['label'=> 'Home','active'=>false, 'route'=> 'employee.home'],
['label'=> 'Office Employees','active'=>true, 'route' => 'employee.office.index'],
['label'=> 'View Employee','active'=>true, 'route' => 'employee.office.view','routefielddata' => $employee->id],
['label'=> 'Add Employee Address','active'=>true],
]])
@endsection


@section('sidebarmenu')

@endsection

@section('content')

<form action="{{ route('employee.updateAddressDetails') }}" method="POST"
    onsubmit="return confirm('Above Written Details are correct to my knowledge. ( मेरे द्वार भरा गया उपरोक्त डाटा सही हैं ) ??? ');">
    @csrf

    <div class="row">
        <div class="form-group col-md-3">
            @include('hrms.employee.employeeDetailsPartial._employee_basicPartial',['routeParameter'=>['employee'=>$employee]])
        </div>
        <div class="form-group  col-sm-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        {{-- address_type_id --}}
                        <div class="form-group col-md-3">
                            <label class="required" for="address_type_id"> Address Type </label>
                            <select id="address_type_id" class="form-select" required="" name="address_type_id">
                                @if($addressType == 1)<option value="1">Correspondence</option> @endif
                                @if($addressType == 2)<option value="2">Permanent</option> @endif
                                @if($addressType == 3)<option value="3">Home</option> @endif
                            </select>

                            @if($errors->has('address_type_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('address_type_id') }}
                            </div>
                            @endif
                            <span class="help-block">
                                @if($employee->getAddress(1))
                                <input type="checkbox" name="same_address" id="same_address"
                                    onclick="same_as_correspond_address()" />
                                <label for="same_address"> Same as Correspondence </label>
                                <br /><br />
                                @endif
                            </span>
                        </div>

                        {{-- state_id --}}
                        <div class="form-group col-md-3">
                            <label class="required" for="state_id"> State Name </label>
                            {!! Form::select('state_id', $states, ($address->state_id ? $address->state_id : 5),
                            ['id' => 'state_id', 'class'=>'form-select select2', 'required',
                            'onchange' =>'fillOtherDetails()']) !!}
                            @if($errors->has('state'))
                            <div class="invalid-feedback">
                                {{ $errors->first('state_id') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>

                        {{-- district_id --}}
                        <div class="form-group col-md-3 addStatedetails">
                            <label class="required" for="district_id"> District </label>
                            {!! Form::select('district_id', $districts, '',
                            ['id' => 'district_id', 'class'=>'form-select select2 forUk ', 'required']) !!}
                            @if($errors->has('district_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('district_id') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>

                        {{-- tehsil_id --}}
                        <div class="form-group col-md-3 addStatedetails ">
                            <label class="required" for="tehsil_id"> Tehsil </label>
                            {!! Form::select('tehsil_id', $tehsils, '',
                            ['id' => 'tehsil_id', 'class'=>'form-select select2 forUk ', 'required']) !!}
                            @if($errors->has('tehsil_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('tehsil_id') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>


                        {{-- vidhansabha_id --}}
                        <div class="form-group col-md-3 addStatedetails ">
                            <label class="required" for="vidhansabha_id"> Vidhansabha </label>
                            {!! Form::select('vidhansabha_id', $constituencies, '',
                            ['id' => 'vidhansabha_id', 'class'=>'form-select select2 forUk ', 'required']) !!}
                            @if($errors->has('vidhansabha_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('vidhansabha_id') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>


                        {{-- address1 --}}
                        <div class="form-group col-md-3">
                            <label class="required" for="address1"> Address </label>
                            <textarea type="text" rows="2" class="form-control" id="address1" name="address1"
                                placeholder="Address" required
                                >{{ ($address->address1 ? $address->address1 : old('address1','')) }}</textarea>
                            @if($errors->has('address1'))
                            <div class="invalid-feedback">
                                {{ $errors->first('address1') }}
                            </div>
                            @endif
                            <span class="help-block"></span>
                        </div>

                        {{-- address2 --}}
                        <div class="form-group col-md-3">
                            <label for="address2"> Address Line 2 </label>
                            <textarea type="text" rows="2" class="form-control" id="address2" name="address2"
                                placeholder="Address"
                                >{{ ($address->address2 ? $address->address2 : old('address2','')) }}</textarea>
                            @if($errors->has('address2'))
                            <div class="invalid-feedback">
                                {{ $errors->first('address2') }}
                            </div>
                            @endif
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group col-md-3 ">
                            <br />
                            {!! Form::hidden('updated_by', Auth::user()->employee_id, ['id'=>'updated_by',
                            'class'=>'form-control', 'required']) !!}
                            <br />
                            <div class="box-footer justify-content-between">
                                <button id="btnAddRegDetails" type="submit" class="btn btn-success">
                                    Update Address </button>
                            </div>
                        </div>
                    </div>
                    <br />
                </div>
            </div>
        </div>
    </div>

    <hr />
    <div class="card">
        <div class="card-body">
            <p class="h5"> Employee Address Details : </p>
            <div class="row">
                <div class="form-group col-md-12">
                    <table class="table border mb-0 dataTable no-footer ">
                        <tr>
                            <th>
                                Address Type
                            </th>
                            <th>
                                State
                            </th>
                            <th>
                                District
                            </th>
                            <th>
                                Tehsil
                            </th>
                            <th>
                                Vidhansabha
                            </th>
                            <th>
                                Address
                            </th>
                        </tr>

                        @if($employee->getAddress(1))
                        <tr>
                            <td>
                                Correspondence Address
                            </td>
                            <td>
                                @if($employee->getAddress(1)->state_id > 0)
                                <label style="display:none;" id="lbl_state_id">
                                    {{$employee->getAddress(1)->state_id}}</label>
                                {{ $employee->getAddress(1)->state_Name->name }}
                                @endif
                            </td>
                            <td>
                                @if($employee->getAddress(1)->district_id)
                                <label style="display:none;" id="lbl_district_id">
                                    {{$employee->getAddress(1)->district_id}}</label>
                                {{ $employee->getAddress(1)->district_Name->name }}
                                @endif
                            </td>
                            <td>
                                @if($employee->getAddress(1)->tehsil_id)
                                <label style="display:none;" id="lbl_tehsil_id">
                                    {{$employee->getAddress(1)->tehsil_id}}</label>
                                {{ $employee->getAddress(1)->tehsil_Name->name }}
                                @endif
                            </td>
                            <td>
                                @if($employee->getAddress(1)->constituency_Name)
                                <label style="display:none;" id="lbl_constituency_id">
                                    {{$employee->getAddress(1)->vidhansabha_id}}</label>
                                {{ $employee->getAddress(1)->constituency_Name->name }}
                                @endif
                            </td>
                            <td>
                                {{-- @if($employee->getAddress(1))@endif --}}
                                <label id="lbl_address1">{{ $employee->getAddress(1)->address1 }}</label>
                                <label id="lbl_address2">{{ $employee->getAddress(1)->address2 }}</label>
                            </td>
                            <td>
                                <a
                                    href="{{ route('employee.updateAddress',['addressType'=>1 ,'employee'=>$employee->id]) }}">
                                    Edit </a>
                            </td>
                        </tr>
                        @endif

                        @if($employee->getAddress(2))
                        <tr>
                            <td>
                                Permanent Address
                            </td>
                            <td>
                                {{ $employee->getAddress(2)->state_id ? $employee->getAddress(2)->state_Name->name : ''
                                }}
                            </td>
                            <td>
                                {{ $employee->getAddress(2)->district_id ? $employee->getAddress(2)->district_Name->name
                                : ''}}
                            </td>
                            <td>
                                {{ $employee->getAddress(2)->tehsil_id ? $employee->getAddress(2)->tehsil_Name->name :
                                '' }}
                            </td>
                            <td>
                                {{$employee->getAddress(2)->vidhansabha_id ?
                                $employee->getAddress(2)->constituency_Name->name : '' }}
                            </td>
                            <td>
                                {{ $employee->getAddress(2)->address1 }} {{ $employee->getAddress(2)->address2 }}
                            </td>
                            <td>
                                <a
                                    href="{{ route('employee.updateAddress',['addressType'=>2 ,'employee'=>$employee->id]) }}">
                                    Edit </a>
                            </td>
                        </tr>
                        @endif

                        @if($employee->getAddress(3))
                        <tr>
                            <td>
                                Home Address
                            </td>
                            <td>

                                @if($employee->getAddress(3)->state_Name)
                                {{ $employee->getAddress(3)->state_Name->name }}@endif
                            </td>
                            <td>
                                @if($employee->getAddress(3)->district_Name)
                                {{ $employee->getAddress(3)->district_Name->name }}@endif
                            </td>
                            <td>
                                @if($employee->getAddress(3)->tehsil_Name)
                                {{ $employee->getAddress(3)->tehsil_Name->name }}@endif
                            </td>
                            <td>
                                @if($employee->getAddress(3)->constituency_Name)
                                {{ $employee->getAddress(3)->constituency_Name->name }}
                                @endif
                            </td>
                            <td>
                                {{ $employee->getAddress(3)->address1 }} &nbsp; {{ $employee->getAddress(3)->address2 }}
                            </td>
                            <td>
                                <a
                                    href="{{ route('employee.updateAddress',['addressType'=>3 ,'employee'=>$employee->id]) }}">
                                    Edit </a>
                            </td>
                        </tr>
                        @endif

                    </table>

                </div>
            </div>

        </div>
    </div>
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