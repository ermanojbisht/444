@extends('layouts.type200.main')


@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
@endsection


@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu',['active'=>'Grivance'])
@endsection

@section('pagetitle')
  Resolve Grivance 
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
['datas'=> [
['label'=> 'Home','active'=>false, 'route'=> 'employee.dashboard'],
['label'=> 'Grivance','active'=>false],
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
                                <label for="grivance_type_id" class="form-label required"> Employee Name ( शिकायतकर्ता का नाम)  </label>
                            </div>
                            <div class="col-md-6">
                                {{ $hr_grivance->creator->name }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="grivance_type_id" class="form-label required"> Employee Id ( शिकायतकर्ता की ई०  डी० ) </label>
                            </div>
                            <div class="col-md-6">
                                {{ $hr_grivance->creator->id }}
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
                        <label for="grivance_type_id" class="form-label required"> Grievance Type ( शिकायत का प्रकार) 
                        </label>
                    </div>
                    <div class="col-md-6">
                        {{ $hr_grivance->grivanceType->name }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label for="office_id" class="form-label required"> Office ( ऑफिस )   </label>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ $hr_grivance->office() }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="description" class="form-label required"> Description of Grievance ( शिकायत का संछिप्त सार) 
                        </label>
                    </div>
                    <div class="col-md-6">
                        {{ $hr_grivance->description }}
                    </div>
                </div>
 
                @if($hr_grivance->documents)
                <div class="row">
                    <div class="col-md-4">
                        <label for="is_document_upload" class="form-label required"> Document </label>
                    </div>
                    <div class="col-md-6">
                        <a   href="{{ route("employee.hr_grivance.doclist",['hr_grivance'=>$hr_grivance->id, 'is_question' => 1]) }}" >
                            <i class="cib-twitter"></i> View Documents 
                        </a>
                    </div>
                </div>

                @endif
                <form action="{{ route('officer.hr_grivance.updateGrievance') }}" method="POST"
                onsubmit="return confirm('Resolvance Given are correct to my knowledge. ( उपरोक्त समस्या के निवारण से में सहमत हूँ  ) ??? ');" >
                    @csrf



                <br />
                <div class="row">
                    <div class="col-md-4">
                        <label for="description" class="form-label required ">  Resolve Grievance ( शिकायत का संछिप्त निवारण)   </label>
                    </div>
                    <div class="col-md-6">
                        <textarea class="form-control" id="draft_answer" rows="3" name="draft_answer" required >{{ old('draft_answer', '') }} </textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="box-footer justify-content-between">
                                <input type="submit" confirm("Press a button!"); id="btnAddRegDetails" class="btn btn-primary" 
                                    value = " Resolve Grievance ( शिकायत का निवारण  करें )"  
                                </button> 
                                <input type="hidden" id="hr_grivance_id" name="hr_grivance_id" value="{{ $hr_grivance->id }}" /> 
                            </div>
                        </div>
                    </div>
                </div> 

                </form>
            </div>
        </div>
    </div>
    <br />

@endsection

@section('footscripts')
@endsection