{{-- @extends('layouts.type100.main') --}}
@extends('layouts.type200.main')


@section('headscripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .row {
        padding-bottom: 20px;
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
        <div class="card-body">
            <div class="row mt-3 mb-3">
                <div class="col-md-6">
                    <p class=""> Employee Name : {{ $hr_grievance->creator->name }} </p>
                </div>
                <div class="col-md-6" style="text-align:right">
                    <p class=""> Employee Id : {{ $hr_grievance->creator->id }} </p>
                </div>
                <br />
                <br />
                <div class="col-md-6">
                    <p class=""> Grievance Type ( शिकायत का प्रकार ) : {{ $hr_grievance->grievanceType->name }} </p>
                </div>
                <div class="col-md-6" style="text-align: right">
                    <p class=""> Office ( ऑफिस ) : {{ $hr_grievance->office() }} </p>
                </div>
                <br />
                <br />
                <div class="col-md-12">
                    <p class=""> Grievance Subject ( विषय ) : {{ $hr_grievance->subject }}
                        @if($hr_grievance->refference_grievance_id)
                        <a style="float: right"
                            href="{{route('employee.hr_grievance.show', ['hr_grievance' => $hr_grievance->refference_grievance_id])}}">
                            View Previous Grievance </a>
                        @endif
                    </p>
                </div>
                <hr />
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p class=""> Grievance Description( शिकायत का संछिप्त सार ) : <br />
                    <p style="padding-left:20px;" class=" "> {{ $hr_grievance->description }} </p>
                    </p>
                </div>
            </div>

            @if(count($hr_grievance->documents) > 0)
            <div class="row">
                <div class="col-md-4">
                    <p class=""> Grievance Document </p>
                </div>
                <div class="col-md-8">
                    <p class="">
                        <a href="{{ route(" employee.hr_grievance.doclist", ['hr_grievance'=>$hr_grievance->id,
                            'is_question' => 1]) }}" > View Documents </a>
                    </p>
                </div>
            </div>
            @endif

            <hr />
            <div class="row">
                <div class="col-md-4">
                    <p class=""> Resolve Grievance ( शिकायत का संछिप्त निवारण) : </p>
                    <br />
                    <p style="padding-left:20px;" class=" "> @if($hr_grievance->final_answer)
                        {{ $hr_grievance->final_answer }}
                        @else
                        Final Answer Not Yet Received
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<br />


@endsection

@section('footscripts')
@endsection