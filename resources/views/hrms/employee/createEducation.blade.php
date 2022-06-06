@extends('layouts.type200.main')

@section('headscripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@include('layouts._commonpartials.css._select2')
@endsection


@section('pagetitle')
Employee Education Detail
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
['datas'=> [
['label'=> 'Home','active'=>false, 'route'=> 'employee.home'],
['label'=> 'Office Employees','active'=>true, 'route' => 'employee.office.index'],
['label'=> 'View Employee','active'=>true, 'route' => 'employee.office.view','routefielddata' => $employee->id],
['label'=> 'Add Education Details','active'=>true],
]])
@endsection

@section('sidebarmenu')

@endsection

@section('content')




<form action="{{ route('employee.education.store') }}" method="POST"
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

                        {{-- Qualification Type --}}
                        <div class="form-group col-md-3">
                            <label class="required" for="qualification_type_id"> Qualification Type </label>
                            {!! Form::select('qualification_type_id', config('hrms.masters.qualificationType'), '1',
                            ['id'=>'qualification_type_id', 'required'=>'required',
                            'class'=>'form-select ' ]) !!}
                            @if($errors->has('qualification_type_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('qualification_type_id') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>


                        {{-- Qualification --}}
                        <div class="form-group col-md-3">
                            <label class="required" for="qualification"> Qualification </label>
                            <input type="text" class="form-control" id="qualification" name="qualification" />

                            @if($errors->has('qualification'))
                            <div class="invalid-feedback">
                                {{ $errors->first('qualification') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>

                        {{-- Year --}}
                        <div class="form-group col-md-3">
                            <label class="required" for="year"> Year </label>
                            <input type="number" min="1965" maxlength="4" max="2999" class="form-control" name="year"
                                id="year" />
                            @if($errors->has('year'))
                            <div class="invalid-feedback">
                                {{ $errors->first('year') }}
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
                                    Save Education Detail </button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <br />

    <div class="card">
        <div class="card-body">

            <p class="h5"> Employee Education Details : </p>
            <div class="row">
                <div class="form-group col-md-12">
                    <table class="table border mb-0 dataTable no-footer ">
                        <tr>
                            <th>
                                Qualification Type
                            </th>
                            <th>
                                Qualification
                            </th>
                            <th>
                                Year Of Passing
                            </th>
                            <th>

                            </th>
                        </tr>

                        @foreach($employeeEducation as $education)
                        <tr>
                            <td>
                                {{ config('hrms.masters.qualificationType')[$education->qualification_type_id] }}
                            </td>
                            <td>
                                {{ $education->qualification }}
                            </td>
                            <td>
                                {{ $education->year }}
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