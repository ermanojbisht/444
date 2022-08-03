@extends('layouts.type200.main')

@section('headscripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@include('layouts._commonpartials.css._select2')
@endsection


@section('pagetitle')
{{($isLastPostingClosed) ? 'Add New Postings' : 'Enter End Date of Current Posting ' }}
for Employee {{$posting->employee->name}} ({{$posting->employee->id}})
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
['datas'=> [
['label'=> 'Home','active'=>false, 'route'=> 'employee.home'],
['label'=> 'Office Employees','active'=>true, 'route' => 'employee.office.index'],
['label'=> 'View Employee','active'=>true, 'route' => 'employee.office.view','routefielddata' =>
$posting->employee->id],
['label'=> 'Add New Postings','active'=>true],
]])
@endsection

@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_hrms',['active'=>'Employees'])
@endsection

@section('content')

@if($isLastPostingClosed)

<form action="{{ route('employee.postings.updateDetails') }}" method="POST"
    onsubmit="return confirm('Above Written Details are correct to my knowledge. ( मेरे द्वार भरा गया उपरोक्त डाटा सही हैं ) ??? ');">
    @csrf

    <div class="row">

        <div class="form-group  col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        {{-- designation_id --}}
                        <div class="form-group col-md-3">
                            <label class="required" for="designation_id"> Designation </label>
                            {!! Form::select('designation_id', $designations,
                            $posting->designation_id, ['id' => 'designation_id',
                            'class'=>'form-select select2', 'required']) !!}
                            @if($errors->has('designation_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('designation_id') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>

                        {{-- office_id --}}
                        <div class="form-group col-md-3">
                            <label class="required" for="office_id"> Office </label>
                            {!! Form::select('office_id', $offices,
                            ($posting->office) ? $posting->office->id : '', ['id' => 'office_id',
                            'class'=>'form-select select2', 'required']) !!}
                            @if($errors->has('office_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('office_id') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>


                        {{-- order_no --}}
                        <div class="form-group col-md-3">
                            <label class="" for="order_no"> Order No </label>
                            <input type="text" class="form-control" id="order_no" name="order_no"
                                placeholder="Order No" 
                                value="{{$posting->order_no ? $posting->order_no : '' }}" />
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
                                value="{{$posting->order_at ? $posting->order_at->format('Y-m-d') : old('order_at', '') }} ">
                            @if($errors->has('order_at'))
                            <div class="invalid-feedback">
                                {{ $errors->first('order_at') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>
                    </div>
                    <br />
                    <div class="row">
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

                        {{-- From Date --}}
                        <div class="form-group col-md-3">
                            <label class="required" for="from_date"> From Date </label>
                            <input class="form-control {{ $errors->has('from_date') ? 'is-invalid' : '' }}" type="date"
                                name="from_date" id="from_date" format required 
                                value="{{  ($posting->from_date) ? $posting->from_date->format('Y-m-d') : old('from_date', '')}}">
                            @if($errors->has('from_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('from_date') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>


                        {{-- To Date --}}
                        <div class="form-group col-md-3">
                            <label class="required" for="to_date"> To Date </label>
                            <input class="form-control {{ $errors->has('to_date') ? 'is-invalid' : '' }}" type="date"
                                name="to_date" id="to_date" format required 
                                value="{{  ($posting->to_date) ? $posting->to_date->format('Y-m-d') : old('to_date', '')}}">
                            @if($errors->has('to_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('to_date') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>

                        <div class="form-group col-md-3">
                            <br />
                            {!! Form::hidden('id', $posting->id, ['id'=>'id', 'class'=>'form-control', 'required']) !!}
                            {!! Form::hidden('employee_id', $posting->employee->id, ['id'=>'employee_id',
                            'class'=>'form-control', 'required']) !!}

                            <div class="box-footer justify-content-between">
                                <button id="btnAddRegDetails" type="submit" class="btn btn-success">
                                    Update Posting Detail </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br />
</form>
@endif

<div class="card">
    <div class="card-body text-info">
        <div class="row">
            <p class="h5"> Change in Posting Dates can affect these postings : </p>
            <div class="form-group col-md-12">
                <table id="tbl_employee_postings" class="table border mb-0 dataTable no-footer ">
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
                            Days
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>

                    @if ($prevposting)
                    <tr style="background-color: #B0D8FF">
                        <td colspan="6">
                            <p class="h5"> Employee Previous Posting Details : </p>
                        </td>
                    </tr>
                    <tr style="background-color: #B0D8FF">
                        <td>
                            <span id="lbloffice{{$prevposting->id}}"> {{ $prevposting->postingOffice->name }} </span>
                        </td>
                        <td>
                            @if ($prevposting->designation_id)
                            <label id="lbldesignation{{$prevposting->id}}"> {{ $prevposting->designation->name }}
                            </label> 
                            @endif
                        </td>
                        <td>
                            {{$prevposting->from_date->format('d M Y')}}
                        </td>
                        <td>
                            @if($prevposting->to_date)
                            {{ $prevposting->to_date->format('d M Y') }}
                            @else
                            Till Present
                            @endif
                        </td>
                        <td>
                            @if($prevposting->s_d || $prevposting->d_d)
                            @if($prevposting->s_d)
                            {{ $prevposting->s_d }} Days Sugam
                            @endif

                            @if ($prevposting->d_d)
                            {{ $prevposting->s_d }} Days Durgam
                            @endif
                            @else
                            @if($prevposting->to_date)
                            {{ 1 +
                            (int)(Carbon\Carbon::parse($prevposting->from_date)->diffInDays(Carbon\Carbon::parse($prevposting->to_date)))
                            }}
                            @else
                            {{ 1 +
                            (int)Carbon\Carbon::parse('2022-05-31')->diffInDays(Carbon\Carbon::parse($prevposting->from_date))
                            }}
                            Till 31/05/22
                            @endif
                            @endif
                        </td>
                        <td>
                            <a class="dropdown-item" target="_blank"
                                href="{{ route('employee.editPosting',['posting'=>$prevposting->id]) }}">
                                Edit </a>

                            @if(! $prevposting->to_date)
                            <a href="javascript:void(0)" onclick="showModal({{$prevposting->id}})">
                                Add End Date
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endif
                    <tr style="background-color: #C6FFC6">
                        <td colspan="6">
                            <p class="h5"> Posting To be Edited : </p>
                        </td>
                    </tr>
                    <tr tooltip="row to edit" style="background-color: #C6FFC6">
                        <td> 
                            {{ $posting->postingOffice->name }}  
                        </td>
                        <td>
                            @if ($posting->designation_id)
                           {{ $posting->designation->name }}  
                             
                            @endif
                        </td>
                        <td>
                            {{$posting->from_date->format('d M Y')}}
                        </td>
                        <td>
                            @if($posting->to_date)
                            {{ $posting->to_date->format('d M Y') }}
                            @else
                            Till Present
                            @endif
                        </td>
                        <td>
                            @if($posting->s_d || $posting->d_d)
                            @if($posting->s_d)
                            {{ $posting->s_d }} Days Sugam
                            @endif

                            @if ($posting->d_d)
                            {{ $posting->s_d }} Days Durgam
                            @endif
                            @else
                            @if($posting->to_date)
                            {{ 1 +
                            (int)(Carbon\Carbon::parse($posting->from_date)->diffInDays(Carbon\Carbon::parse($posting->to_date)))
                            }}
                            @else
                            {{ 1 +
                            (int)Carbon\Carbon::parse('2022-05-31')->diffInDays(Carbon\Carbon::parse($posting->from_date))
                            }}
                            Till 31/05/22
                            @endif
                            @endif 
                        </td>
                        <td></td>
                    </tr>

                    @if ($nextPosting)
                    <tr style=" background-color : #f9d7d7">
                        <td colspan="6">
                            <p class="h5"> Employee's Next Posting Details : </p>
                        </td>
                    </tr>
                    <tr style=" background-color : #f9d7d7">
                        <td>
                              {{ $nextPosting->postingOffice->name }}  
                        </td>
                        <td>
                            @if ($nextPosting->designation_id)
                              {{ $nextPosting->designation->name }}
                            @endif
                        </td>
                        <td>
                            {{$nextPosting->from_date->format('d M Y')}}
                        </td>
                        <td>
                            @if($nextPosting->to_date)
                            {{ $nextPosting->to_date->format('d M Y') }}
                            @else
                            Till Present
                            @endif
                        </td>
                        <td>
                            @if($nextPosting->s_d || $nextPosting->d_d)
                            @if($nextPosting->s_d)
                            {{ $nextPosting->s_d }} Days Sugam
                            @endif

                            @if ($nextPosting->d_d)
                            {{ $nextPosting->s_d }} Days Durgam
                            @endif
                            @else
                            @if($nextPosting->to_date)
                            {{ 1 +
                            (int)(Carbon\Carbon::parse($nextPosting->from_date)->diffInDays(Carbon\Carbon::parse($nextPosting->to_date)))
                            }}
                            @else
                            {{ 1 +
                            (int)Carbon\Carbon::parse('2022-05-31')->diffInDays(Carbon\Carbon::parse($nextPosting->from_date))
                            }}
                            Till 31/05/22
                            @endif
                            @endif 
                        </td>
                        <td>
                            <a class="dropdown-item" target="_blank"
                                href="{{ route('employee.editPosting',['posting'=>$nextPosting->id]) }}">
                                Edit </a>
                            @if(! $nextPosting->to_date)
                            <a href="javascript:void(0)" onclick="showModal({{$nextPosting->id}})">
                                Add End Date
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endif
                </table>
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