@extends('layouts.type200.main')


@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
@endsection


@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_hr_gr',['active'=>'Grievance'])
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
                <div class="col-md-12">
                    <h5> View Draft for Resolving Grievance /
                        शिकायत का संछिप्त निवारण (ड्राफ्ट) : </h5>
                    <h6> @if($hr_grievance->draft_answer)
                        {{ $hr_grievance->draft_answer }}
                        @else
                        Draft Answer Not Yet Received
                        @endif
                    </h6>
                </div>

            </div>



            @if(count($hr_grievance->documents) > 0)
            <div class="row">
                <div class="col-md-4">
                    <label for="is_document_upload" class="form-label required"> Document </label>
                </div>
                <div class="col-md-8">
                    <a href="{{ route(" employee.hr_grievance.doclist",['hr_grievance'=>$hr_grievance->id, 'is_question'
                        => 1]) }}" >
                        <i class="cib-twitter"></i> View Documents
                    </a>
                </div>
            </div>

            @endif

            <form action="{{ route('hr_grievance.resolveGrievance') }}" method="POST"
                onsubmit="return confirm('Resolvance Given are correct to my knowledge. ( उपरोक्त समस्या के निवारण से में सहमत हूँ  ) ??? ');">
                @csrf

                <br />
                <div class="row">
                    <div class="col-md-4">
                       <h5>  Add Final Answer for Resolving Grievance /
                        शिकायत का संछिप्त निवारण  :  </h5>
                    </div>
                    <div class="col-md-8">
                        <textarea class="form-control" id="final_answer" rows="3" name="final_answer"
                            required>{{ old('final_answer', '') }}</textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="box-footer justify-content-between">
                                <input type="submit" confirm("Press a button!"); id="btnAddRegDetails"
                                    class="btn btn-primary" value="Resolve Grievance ( शिकायत का निवारण  करें )"
                                    </button>
                                <input type="hidden" id="hr_grievance_id" name="hr_grievance_id"
                                    value="{{ $hr_grievance->id }}" />
                                <input type="hidden" id="status_id" name="status_id" value="3" />
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