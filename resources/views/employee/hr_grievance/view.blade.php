{{-- @extends('layouts.type100.main') --}}
@extends('layouts.type200.main')


@section('headscripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .row {
        padding-bottom: 20px;
    }

    .bgletter {
        background: url('{{ asset("../images/img_letter.png") }}') no-repeat;
        background-size: 100% 180%;
    }
</style>
@endsection


@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
['datas'=> [
['label'=> 'Home','active'=>false, 'route'=> 'employee.home'],
['label'=> 'Grievance','active'=>false],
['label'=> 'List','active'=>false, 'route' => 'employee.hr_grievance'],
['label'=> 'View','active'=>true],
]])
@endsection

@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_hr_gr',['active'=>'Grienvance'])
@endsection



@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body bgletter">

            <div class="row mt-5 mb-3">
                <div class="col-md-12">

                    <div style="padding-left:100px;">
                         To,<div style="float: right;padding-right:100px;"> Dated : {{$hr_grievance->created_at ?
                            $hr_grievance->created_at->format('d M Y') : ''}}</div><br /> 
                            {{ $finalOfficer->name }}, <br />
                        {{ $hr_grievance->office() }},Public Works Department, <br />
                        Uttarakhand. <br />
                        <br /> 
                        <b> Subject </b> : {{ $hr_grievance->grievanceType->name }}, &nbsp; {{ $hr_grievance->subject }}
                        @if($hr_grievance->refference_grievance_id)
                        <a class="btn btn-warning btn-sm" href="{{route('employee.hr_grievance.show', ['hr_grievance' => $hr_grievance->refference_grievance_id])}}">
                            View Previous Linked Grievance </a>
                        @endif
                        <br />
                        <br />
                            <p style="padding-left: 70px;"> {{ $hr_grievance->description }}  </p>
                        <br />
                        <br /> 
                        From: - <br />
                        {{ $hr_grievance->creator->name }}, <br />
                        Employee Id : {{ $hr_grievance->creator->id }} <br />
                        
                        @if(count($hr_grievance->documents) > 0)
                        <hr />
                        <div class="row">
                            <div class="col-md-4">
                                <p> Attached Document : </p>
                            </div>
                            <div class="col-md-8">
                                <p>
                                    <a href="{{ route("employee.hr_grievance.doclist", ['hr_grievance'=>$hr_grievance->id,
                                        'is_question' => 1]) }}" > View Uploaded Documents </a>
                                </p>
                            </div>
                        </div>
                        @endif
                        <br/> 
                        <hr />
                        <div class="row">
                            <div class="col-md-12">
                                <p style="padding-left:20px;" class=" "> @if($hr_grievance->final_answer)
                                    {{ $hr_grievance->final_answer }}
                                    @else
                                    Answer Not Yet Received 
                                    @endif
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
</div>
<br />


@endsection

@section('footscripts')
@endsection