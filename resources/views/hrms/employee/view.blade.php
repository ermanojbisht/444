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
        <div class="form-group col-md-3">
            {{-- Employee Code --}}
            <label class="h6 form-label"> Employee Code : </label>
            <label class="form-label"> {{$employee->id }}</label>
            <br />

            {{-- Employee Name --}}
            <label class="h6 form-label"> Name : </label>
            <label class="form-label"> {{$employee->name }} </label>
            <br />

            {{-- Father's / Husband Name --}}
            <label class="h6 form-label"> Father's / Husband Name : </label>
            <label class="form-label"> {{$employee->father_name }} </label>
            <br />

            {{-- Gender --}}
            <label class="h6 form-label"> Gender : </label>
            <label class="form-label"> {{ config('hrms.masters.gender')[$employee->gender_id] }} </label>
            <br />

            {{-- Date of Birth --}}
            <label class="h6 form-label"> Date of Birth : </label>
            <label class="form-label"> {{$employee->birth_date->format('d M Y') }} </label>
            <br />

            {{-- Date of Retirement --}}
            <label class="h6 form-label"> Date of Retirement : </label>
            <label class="form-label"> {{$employee->retirement_date->format('d M Y') }} </label>
            <br />

            {{-- Mobile No --}}
            <label class="h6 form-label"> Mobile No : </label>
            <label class="form-label"> {{$employee->phone_no }}
                {{-- Alternate Mobile No --}}
                @if($employee->phone_no1)
                ,{{$employee->phone_no1 }}
                @endif
            </label>
            <br />

            {{-- Email Address --}}
            <label class="h6 form-label"> Email Address : </label>
            <label class="form-label"> {{$employee->email }} </label>
            <br />

            {{-- Pan --}}
            <label class="h6 form-label"> Pan : </label>
            <label class="form-label"> {{$employee->pan }} </label>
            <br />

            {{-- Aadhar --}}
            <label class="h6 form-label"> Aadhar : </label>
            <label class="form-label"> {{$employee->aadhar }} </label>
            <br />

            {{-- Blood Group --}}
            <label class="h6 form-label"> Blood Group : </label>
            <label class="form-label"> {{ config('hrms.masters.bloodGroup')[$employee->blood_group_id] }} </label>
            <br />

            {{-- Religion --}}
            <label class="h6 form-label"> Religion : </label>
            <label class="form-label"> {{ config('hrms.masters.religion')[$employee->religion_id] }} </label>
            <br />

            {{-- Martial Status --}}
            <label class="h6 form-label"> Martial Status : </label>
            <label class="form-label"> {{ config('hrms.masters.married')[$employee->is_married] }} </label>
            <br />

            {{-- Cast Category --}}
            <label class="h6 form-label"> Category : </label>
            <label class="form-label"> {{ config('hrms.masters.cast')[$employee->cast_id] }} </label>
            <br />

            {{-- Sub - Category --}}
            <label class="h6 form-label"> Sub - Category : </label>
            <label class="form-label"> {{ config('hrms.masters.disability')[$employee->benifit_category_id] }} </label>
            <br />



            {{-- Height --}}
            <label class="h6 form-label"> Height : </label>
            <label class="form-label"> {{ $employee->height }} cm </label>
            <br />

            {{-- Identity Mark --}}
            <label class="h6 form-label"> Identity Mark : </label>
            <label class="form-label"> {{ $employee->identity_mark }} </label>
            <br />

            {{-- Order Date --}}
            <label class="h6 form-label"> Order Date : </label>
            <label class="form-label"> {{ $employee->transfer_order_date->format('Y-m-d') }} </label>
            <br />

            {{-- Designation --}}
            <label class="h6 form-label"> Designation : </label>
            <label class="form-label"> {{ $employee->designation_Name->name }} </label>
            <br />

            {{-- Office Name --}}
            <label class="h6 form-label"> Office : </label>
            <label class="form-label"> {{ $employee->office_Name->name }} </label>




        </div>
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