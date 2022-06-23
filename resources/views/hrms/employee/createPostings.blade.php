@extends('layouts.type200.main')

@section('headscripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@include('layouts._commonpartials.css._select2')
@endsection


@section('pagetitle')
Employee Postings Detail
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
['datas'=> [
['label'=> 'Home','active'=>false, 'route'=> 'employee.home'],
['label'=> 'Office Employees','active'=>true, 'route' => 'employee.office.index'],
['label'=> 'View Employee','active'=>true, 'route' => 'employee.office.view','routefielddata' => $employee->id],
['label'=> 'Add Posting Details','active'=>true],
]])
@endsection

@section('sidebarmenu')
@endsection

@section('content')

<form action="{{ route('employee.postings.store') }}" method="POST"
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


                        {{-- Relieving Date --}}
                        <div class="form-group col-md-3">
                            <label class="" for="to_date"> Relieving Date </label>
                            <input class="form-control {{ $errors->has('to_date') ? 'is-invalid' : '' }}" type="date"
                                name="to_date" id="to_date" format required
                                value="{{$employee->to_date ? $employee->to_date->format('Y-m-d') : old('to_date', '') }}">
                            @if($errors->has('to_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('to_date') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>

                        
                        {{-- Mode --}}
                        <div class="form-group col-md-3">
                            <label class="required" for="mode_id"> Mode </label>
                            {!! Form::select('mode_id', config('hrms.masters.historyType'), '1',
                            ['id'=>'mode_id', 'required'=>'required', 'class'=>'form-select ' ]) !!}
                            @if($errors->has('mode_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('mode_id') }}
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

                        {{-- Order Date --}}
                        <div class="form-group col-md-3">
                            <label class="" for="order_at"> Order Date </label>
                            <input class="form-control {{ $errors->has('order_at') ? 'is-invalid' : '' }}" type="date"
                                name="order_at" id="order_at" format
                                value="@if($employeePostings->count() == 0){{$employee->transfer_order_date->format('Y-m-d')}}@else{{$employee->order_at ? $employee->order_at->format('Y-m-d') : old('order_at', '') }}@endif">
                            @if($errors->has('order_at'))
                            <div class="invalid-feedback">
                                {{ $errors->first('order_at') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>

                        {{-- From Date --}}
                        <div class="form-group col-md-3">
                            <label class="required" for="from_date"> From Date </label>
                            <input class="form-control {{ $errors->has('from_date') ? 'is-invalid' : '' }}" type="date"
                                name="from_date" id="from_date" format required

                                @if($employeePostings->count() > 0)
                                value="{{$employee->from_date ? $employee->from_date->format('Y-m-d') : old('from_date', '')}}"  
                                @else
                                value="{{ $employee->joining_date->format('Y-m-d') }}"
                                @endif
                             >
                            @if($errors->has('from_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('from_date') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>

                        @if($employeePostings->count() > 0)

                        

                        {{-- is_prabhari --}}
                        <div class="form-group col-md-3">
                            <label class="is_prabhari" for="to_date"> Is Prabhari </label>
                            <br />
                            {!! Form::radio('is_prabhari', '1', '',
                            ['id' => 'is_prabhari_Yes', 'class'=>'radio ', 'required']) !!}

                            {!! Form::label('is_prabhari_Yes', 'Is Not Prabhari', ['class'=>'label']) !!}

                            <br />
                            {!! Form::radio('is_prabhari', '0', '',
                            ['id' => 'is_prabhari_No', 'class'=>'radio ', 'required']) !!}
                            {!! Form::label('is_prabhari_No', 'Is Prabhari', ['class'=>'label']) !!}

                            @if($errors->has('is_prabhari'))
                            <div class="invalid-feedback">
                                {{ $errors->first('is_prabhari') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>


                        {!! Form::hidden('firstJoining', '0', ['id' => 'to_date', 'required']) !!}

                        @else
                        {{-- {!! Form::text($name, $value, [$options]) !!} --}}
                        {!! Form::hidden('is_prabhari', '0', ['id' => 'is_prabhari', 'required']) !!}
                        {!! Form::hidden('to_date', '', ['id' => 'to_date', 'required']) !!}
                        {!! Form::hidden('firstJoining', '1', ['id' => 'to_date', 'required']) !!}

                        @endif

                        

                        {{-- is_designation_changed --}}
                        <div class="form-group col-md-3">
                            <label class="is_prabhari" for="to_date"> Is Designation Changed </label>
                            <br />
                            {!! Form::radio('is_designation_changed', '1', '',
                            ['id' => 'is_designation_changed_Yes', 'class'=>'radio ', 'required']) !!}

                            {!! Form::label('is_designation_changed_Yes', 'No Designation Changed', ['class'=>'label'])
                            !!}

                            <br />
                            {!! Form::radio('is_designation_changed', '0', '',
                            ['id' => 'is_designation_changed_No', 'class'=>'radio ', 'required']) !!}
                            {!! Form::label('is_designation_changed_No', 'Designation Changed', ['class'=>'label']) !!}

                            @if($errors->has('is_designation_changed'))
                            <div class="invalid-feedback">
                                {{ $errors->first('is_designation_changed') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>


                        {{-- designation_id --}}
                        <div class="form-group col-md-3">
                            <label class="required" for="designation_id"> Designation </label>
                            {!! Form::select('designation_id', $designations, $employee->current_designation_id,
                            ['id' => 'designation_id', 'class'=>'form-select select2','disable'=>'disable', 'required']) !!}
                            @if($errors->has('designation_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('designation_id') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>


                        {{-- office_id --}}
                        <div class="form-group col-md-3">
                            <label class="required" for="office_id"> Office </label> <br />
                            {!! Form::select('office_id', $offices, $employee->officeName->id,
                            ['id' => 'office_id', 'class'=>'form-select select2', 'required']) !!}
                            @if($errors->has('office_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('office_id') }}
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
                                Office
                            </th>
                            <th>
                                Designation
                            </th>
                            <th>
                                From Date
                            </th>
                            <th>
                                To Date
                            </th>
                            <th>
                                Mode
                            </th>
                            <th></th>
                        </tr>

                        @foreach($employeePostings as $posting )
                        <tr>
                            <td>
                                {{ $posting->officeName->name }}
                            </td>
                            <td>
                                {{ $posting->designationName->name }}
                            </td>
                            <td>
                                {{$posting->from_date->format('d M Y')}}
                            </td>
                            <td>
                                @if($posting->to_date)
                                {{ $posting->from_date->format('d M Y') }}
                                @else
                                Till Present
                                @endif
                            </td>
                            <td>
                                {{ config('hrms.masters.historyType')[$posting->mode_id] }}
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