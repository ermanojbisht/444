@extends('layouts.type200.main')

@section('headscripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@include('layouts._commonpartials.css._select2')
@endsection


@section('pagetitle')
Add Employee Families
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
['datas'=> [
['label'=> 'Home','active'=>false, 'route'=> 'employee.home'],
['label'=> 'Office Employees','active'=>true, 'route' => 'employee.office.index'],
['label'=> 'View Employee','active'=>true, 'route' => 'employee.office.view','routefielddata' => $employee->id],
['label'=> 'Add Employee Family','active'=>true],
]])
@endsection

@section('sidebarmenu')

@endsection

@section('content')

<form action="{{ route('employee.family.store') }}" method="POST"
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
                        {{-- Family Member Name --}}
                        <div class="form-group col-md-3">
                            <label class="required" for="name"> Family Member's Name </label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                                minlength="3" maxlength="150" name="name" id="name" value="{{ old('name', '') }}"
                                placeholder="Family Member's Name" required>
                            @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>

                        {{-- Relation --}}
                        <div class="form-group col-md-3">
                            <label class="required" for="relation_id"> Relation </label>
                            {!! Form::select('relation_id', config('hrms.masters.relation'), '0',
                            ['id'=>'relation_id', 'required'=>'required', 'class'=>'form-select ' ]) !!}
                            @if($errors->has('relation_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('relation_id') }}
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

                        {{-- Nominee Percentage --}}
                        <div class="form-group col-md-3">
                            <label class="required" for="nominee_percentage"> Nominee Percentage </label>
                            <input class="form-control {{ $errors->has('nominee_percentage') ? 'is-invalid' : '' }}"
                                type="number" maxlength="3" minlength="1" name="nominee_percentage"
                                id="nominee_percentage" value="{{ old('nominee_percentage', '') }}"
                                placeholder="Enter number for Percentage" required>
                            @if($errors->has('nominee_percentage'))
                            <div class="invalid-feedback">
                                {{ $errors->first('nominee_percentage') }}
                            </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <br />
                    <div class="row">

                        <div class="form-group col-md-3">
                            {!! Form::hidden('updated_by', Auth::user()->employee_id, ['id'=>'updated_by',
                            'class'=>'form-control', 'required']) !!}
                            <br />
                            <div class="box-footer justify-content-between">
                                <button id="btnAddFamilyDetails" type="submit" class="btn btn-success">
                                    Save Family Detail </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <br />

    <hr />
    <div class="card">
        <div class="card-body">
            <p class="h5"> Employee Family Details : </p>
            <div class="row">
                <div class="form-group col-md-12">
                    <table class="table border mb-0 dataTable no-footer ">
                        <tr>
                            <th>
                                Family Member's Name
                            </th>
                            <th>
                                Relation
                            </th>
                            <th>
                                Date of Birth
                            </th>
                            <th>
                                Nominee Percentage
                            </th>
                            <th>

                            </th>
                        </tr>
                        @foreach($employeeFamily as $family)
                        <tr>
                            <td>
                                {{ $family->name }}
                            </td>
                            <td>
                                {{ config('hrms.masters.relation')[$family->relation_id] }}
                            </td>
                            <td>
                                @if($family->birth_date)
                                {{ $family->birth_date->format('d M Y') }}
                                @endif
                            </td>
                            <td>
                                {{ $family->nominee_percentage }} %
                            </td>
                            <td>
                                <a href="#"> Edit </a>
                            </td>
                        </tr>
                        @endforeach

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

    // function countCharacters(thiss, lblShowCounterId)
    // {
    //     $("#" +lblShowCounterId).html(thiss.value.length);
    // }
</script>
@include('partials.js._makeDropDown')
@endsection