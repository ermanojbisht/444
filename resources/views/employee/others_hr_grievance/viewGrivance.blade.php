@extends('layouts.type200.main')


@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
@endsection


@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu',['active'=>'Grievance'])
@endsection

@section('pagetitle')
  Resolve Grievance 
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
['datas'=> [
['label'=> 'Home','active'=>false, 'route'=> 'employee.home'],
['label'=> 'Grievance','active'=>false],
['label'=> 'Resolve','active'=>true],
]])
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10">
                        <h3 class="card-title"> Fill your grievances ( शिकायत निवारण हेतु आवेदन फार्म) </h3>
                        <hr />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10">
                        <h5> Applicant's Description (आवेदक का विवरण) </h5>
                        <hr />
                        <div class="row">
                            <div class="col-md-4">
                                <label for="grievance_type_id" class="form-label required"> Employee Name ( शिकायतकर्ता का नाम)  </label>
                            </div>
                            <div class="col-md-6">
                                {{ $hr_grievance->creator->name }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="grievance_type_id" class="form-label required"> Employee Id ( शिकायतकर्ता की ई०  डी० ) </label>
                            </div>
                            <div class="col-md-6">
                                {{ $hr_grievance->creator->id }}
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10">
                        <h5> Grievance Detail(शिकायत का विवरण) </h5>
                        <hr />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label for="grievance_type_id" class="form-label required"> Grievance Type ( शिकायत का प्रकार) 
                        </label>
                    </div>
                    <div class="col-md-6">
                        {{ $hr_grievance->grievanceType->name }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label for="office_id" class="form-label required"> Office ( ऑफिस )   </label>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ $hr_grievance->office() }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="description" class="form-label required"> Description of Grievance ( शिकायत का संछिप्त सार) 
                        </label>
                    </div>
                    <div class="col-md-6">
                        {{ $hr_grievance->description }}
                    </div>
                </div>
 
                <div class="row">
                    <div class="col-md-4">
                        <label for="description" class="form-label required ">  Resolve Grievance Draft ( शिकायत का संछिप्त निवारण)   </label>
                    </div>
                    <div class="col-md-6">
                        @if($hr_grievance->draft_answer)
                        {{ $hr_grievance->draft_answer }}
                        @else
                             Draft Answer Not Yet Received
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label for="description" class="form-label required ">  Resolve Grievance Final  ( शिकायत का संछिप्त निवारण)   </label>
                    </div>
                    <div class="col-md-6">
                        @if($hr_grievance->final_answer)
                        {{ $hr_grievance->final_answer }}
                        @else
                             Final Answer Not Yet Received
                        @endif
                    </div>
                </div>


                @if($hr_grievance->documents)
                <div class="row">
                    <div class="col-md-4">
                        <label for="is_document_upload" class="form-label required"> Document </label>
                    </div>
                    <div class="col-md-6">
                        <a   href="{{ route("employee.hr_grievance.doclist",['hr_grievance'=>$hr_grievance->id, 'is_question' => 1]) }}" >
                            <i class="cib-twitter"></i> View Documents 
                        </a>
                    </div>
                </div>

                @endif
                
                
                

                 

            </div>
        </div>
    </div>
    <br />

@endsection

@section('footscripts')
@endsection