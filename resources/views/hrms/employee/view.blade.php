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
['label'=> 'Office Employees','active'=>true, 'route' => 'employee.office.index'],
['label'=> 'View Employee','active'=>true],
]])
@endsection

@section('sidebarmenu')
@endsection

@section('content')
<div class="row">
    <div class="form-group col-md-3">
        @include('hrms.employee.employeeDetailsPartial._employee_basicPartial',['routeParameter'=>['employee'=>$employee]])
    </div>

    <div class="form-group  col-sm-9">
        <div class="card">
            <div class="card-body">

                <div class="row">

                    <a href="{{ route('employee.editBasicDetails',['employee'=>$employee->id]) }}"
                        class="btn btn-outline-success col-5 m-1"> Add Basic Details </a>

                    <a href="{{ route('employee.createAddress',['employee'=>$employee->id]) }}"
                        class="btn btn-outline-success col-5 m-1"> Add Address Details </a>

                    <a href="{{ route('employee.createFamilyDetails',['employee'=>$employee->id]) }}"
                        class="btn btn-outline-success col-5 m-1"> Add Family Details </a>

                    <a href="{{ route('employee.AddEducationDetails',['employee'=>$employee->id]) }}"
                        class="btn btn-outline-success col-5 m-1"> Add Education Details </a>

                    <a href="{{ route('employee.posting.create',['employee'=>$employee->id]) }}"
                        class="btn btn-outline-success col-5 m-1"> Add Posting Details </a>

                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('footscripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(".select2").select2();
</script>
@include('partials.js._makeDropDown')
@endsection



{{-- <li class="list-group-item d-flex justify-content-between">
    <span class="fw-bold"> Mobile No :</span>
    <span> {{$employee->phone_no }} @if($employee->phone_no1) ,{{$employee->phone_no1 }} @endif
    </span>
</li>

<li class="list-group-item d-flex justify-content-between">
    <span class="fw-bold"> Aadhar :</span>
    <span> {{$employee->aadhar }} </span>
</li>

<li class="list-group-item d-flex justify-content-between">
    <span class="fw-bold"> Religion :</span>
    <span> {{ config('hrms.masters.religion')[$employee->religion_id] }} </span>
</li>

<li class="list-group-item d-flex justify-content-between">
    <span class="fw-bold"> Category :</span>
    <span> {{ config('hrms.masters.cast')[$employee->cast_id] }} </span>
</li>

<li class="list-group-item d-flex justify-content-between">
    <span class="fw-bold"> Height :</span>
    <span> {{ $employee->height }} cm </span>
</li>
<li class="list-group-item d-flex justify-content-between">
    <span class="fw-bold"> Identity Mark :</span>
    <span> {{ $employee->identity_mark }} </span>
</li>

<li class="list-group-item d-flex justify-content-between">
    <span class="fw-bold"> Father's / Husband Name :</span>
    <span> {{$employee->father_name }}</span>
</li>

<li class="list-group-item d-flex justify-content-between">
    <span class="fw-bold"> Date of Retirement :</span>
    <span> {{$employee->retirement_date->format('d M Y') }}</span>
</li>

<li class="list-group-item d-flex justify-content-between">
    <span class="fw-bold"> Email Address :</span>
    <span> {{$employee->email }}</span>
</li>

<li class="list-group-item d-flex justify-content-between">
    <span class="fw-bold"> Pan :</span>
    <span> {{$employee->pan }} </span>
</li>

<li class="list-group-item d-flex justify-content-between">
    <span class="fw-bold"> Martial Status :</span>
    <span> {{ config('hrms.masters.married')[$employee->is_married] }} </span>
</li>

<li class="list-group-item d-flex justify-content-between">
    <span class="fw-bold"> Sub - Category :</span>
    <span> {{ config('hrms.masters.disability')[$employee->benifit_category_id] }}
    </span>
</li>

<li class="list-group-item d-flex justify-content-between">
    <span class="fw-bold"> Blood Group :</span>
    <span> {{ config('hrms.masters.bloodGroup')[$employee->blood_group_id] }} </span>
</li> --}}