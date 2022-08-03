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

<form action="{{ route('employee.postings.deletePosting', ['posting' => $posting->id])}}" method="POST"
    onsubmit="return confirm('Above Written Details are correct to my knowledge. ( मेरे द्वार भरा गया उपरोक्त डाटा सही हैं ) ??? ');">
    @csrf

    <div class="row">

        <div class="form-group  col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        {{-- designation_id --}}
                        <div class="form-group col-md-3">
                            <label class="" for="designation_id"> Current Designation </label>
                            <br />
                            @if($posting->employee->designation_id)
                            {!! Form::label('', $designations[$posting->employee->designation_id],
                            ['class'=>'label']) !!}
                            <span>@if($posting->employee->regular_incharge == 1) (Incharge) @endif</span>
                            @else
                            Not delclared by Section
                            @endif
                            {!! Form::hidden('regular_incharge', $posting->employee->regular_incharge,
                            ['id'=>'regular_incharge'])
                            !!}
                            {!! Form::hidden('designation_id', $posting->employee->designation_id,
                            ['id'=>'designation_id']) !!}


                            @if($errors->has('designation_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('designation_id') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>

                        {{-- office_id --}}
                        <div class="form-group col-md-3">
                            <label class="" for="office_id"> Current Office </label>
                            <br />
                            {!! Form::label('', $offices[$posting->employee->office_idd], ['class'=>'label']) !!}
                            {!! Form::hidden('office_id', $posting->employee->office->id, ['id'=>'office_id']) !!}
                            @if($errors->has('office_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('office_id') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>


                        {{-- order_no --}}
                        <div class="form-group col-md-3">
                            <label class="" for="order_no"> Order No </label> <br />
                            <label id="order_no" name="order_no">
                                {{$posting->order_no ? $posting->order_no : '_ _ _ _ ' }} </label>
                            @if($errors->has('order_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('order_no') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>

                        {{-- Order Date --}}
                        <div class="form-group col-md-3">
                            <label class="" for="order_at"> Order Date </label> <br />
                            <label name="order_at" id="order_at">
                                {{$posting->order_at ? $posting->order_at->format('Y-m-d') : '_ _ / _ _ / _ _ _ _' }}
                            </label>
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
                            <label for="mode_id"> Mode </label>
                            <br />
                            <label> {{ config('hrms.masters.historyType')[$posting->mode_id ? $posting->mode_id : 1] }}
                            </label>
                            @if($errors->has('mode_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('mode_id') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>

                        {{-- From Date --}}
                        <div class="form-group col-md-3">
                            <label for="from_date"> From Date </label> <br />
                            <label name="from_date" id="from_date">
                                {{ ($posting->from_date) ? $posting->from_date->format('d M Y') : '' }}
                            </label>
                            @if($errors->has('from_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('from_date') }}
                            </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>


                        {{-- To Date --}}
                        <div class="form-group col-md-3">
                            <label for="to_date"> To Date </label><br />
                            <label name="to_date" id="to_date">
                                {{ ($posting->to_date) ? $posting->to_date->format('d M Y') : '' }}
                            </label>
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
                                <button id="btnAddRegDetails" type="submit" class="btn btn-danger">
                                    Delete Posting </button>
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
                    </tr>

                    @if ($prevposting)
                    <tr style="background-color: #B0D8FF">
                        <td colspan="5">
                            <p class="h5"> Employee Previous Posting Details : </p>
                        </td>
                    </tr>
                    <tr style="background-color: #B0D8FF">
                        <td>
                            {{$prevposting->id}}
                            <span id="lbloffice{{$prevposting->id}}"> {{ $prevposting->postingOffice->name }} </span>
                        </td>
                        <td>
                            @if ($prevposting->designation_id)
                            <label id="lbldesignation{{$prevposting->id}}"> {{ $prevposting->designation->name }}
                            </label>
                            <label id="lbldesignationid{{$prevposting->id}}"> {{
                                $prevposting->designation->id }} </label>
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
                    </tr>
                    @endif
                    <tr style="background-color: #f9d7d7">
                        <td colspan="5">
                            <p class="h5"> Posting To be Deleted : </p>
                        </td>
                    </tr>
                    <tr tooltip="row to edit" style="background-color: #f9d7d7">
                        <td>
                            {{$posting->id}}
                            <span id="lbloffice{{$posting->id}}"> {{ $posting->postingOffice->name }} </span>
                        </td>
                        <td>
                            @if ($posting->designation_id)
                            <label id="lbldesignation{{$posting->id}}"> {{ $posting->designation->name }} </label>
                            <label id="lbldesignationid{{$posting->id}}"> {{
                                $posting->designation->id }} </label>
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
                    </tr>

                    @if ($nextPosting)
                    <tr style=" background-color : #C6FFC6">
                        <td colspan="5">
                            <p class="h5"> Employee's Next Posting Details : </p>
                        </td>
                    </tr>
                    <tr style=" background-color : #C6FFC6">
                        <td>
                            {{$nextPosting->id}}
                            <span id="lbloffice{{$nextPosting->id}}"> {{ $nextPosting->postingOffice->name }} </span>
                        </td>
                        <td>
                            @if ($nextPosting->designation_id)
                            <label id="lbldesignation{{$nextPosting->id}}"> {{ $nextPosting->designation->name }}
                            </label>
                            <label id="lbldesignationid{{$nextPosting->id}}"> {{
                                $nextPosting->designation->id }} </label>
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