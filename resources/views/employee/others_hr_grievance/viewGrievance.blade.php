@extends('layouts.type200.main')


@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
@endsection


@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_hr_gr',['active'=>'Grievance'])
@endsection

@section('pagetitle')
Employee's Grievance
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
['datas'=> [
['label'=> 'Home','active'=>false, 'route'=> 'employee.home'],
['label'=> 'Others Grievance','active'=>false, 'route'=> 'resolve_hr_grievance'],
['label'=> 'View','active'=>true],
]])
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row mt-3 mb-3">
                <div class="col-md-6">
                    <h5> Employee Name : {{ $hr_grievance->creator->name }} </h5>
                </div>
                <div class="col-md-6" style="text-align:right">
                    <h5> Employee Id : {{ $hr_grievance->creator->id }} </h5>
                </div>
                <br />
                <br />
                <div class="col-md-6">
                    <h5> Grievance Type ( शिकायत का प्रकार ) : {{ $hr_grievance->grievanceType->name }} </h5>
                </div>
                <div class="col-md-6" style="text-align: right">
                    <h5> Office ( ऑफिस ) : {{ $hr_grievance->office() }} </h5>
                </div>
                <br />
                <br />
                <div class="col-md-12">
                    <h5> Grievance Subject ( विषय ) : {{ $hr_grievance->subject }} </h5>
                </div>
                <hr />
            </div>

            <div class="row">


                <div class="col-md-12">
                    <h5> Grievance Description( शिकायत का संछिप्त सार ) : </h5>
                    <h4> {{ $hr_grievance->description }} </h4>
                </div>
            </div>

            @if(count($hr_grievance->documents) > 0)
            <div class="row">
                <div class="col-md-4">
                    <h6> Grievance Document </h6>
                </div>
                <div class="col-md-8">
                    <h6>
                        <a href="{{ route(" employee.hr_grievance.doclist", ['hr_grievance'=>$hr_grievance->id,
                            'is_question' => 1]) }}" > View Documents </a>
                    </h6>
                </div>
            </div>
            @endif

            <hr />
            <div class="row">
                <div class="col-md-4">
                    <h5>  Resolve Grievance ( शिकायत का संछिप्त निवारण) : </h5>
                    
                   <h6> @if($hr_grievance->final_answer)
                    {{ $hr_grievance->final_answer }}
                    @else
                    Final Answer Not Yet Received
                    @endif 
                </h6> 
                </div>

            </div>
        </div>
    </div>
</div>
<br />


@endsection

@section('footscripts')
@endsection