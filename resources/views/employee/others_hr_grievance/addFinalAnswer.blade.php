@extends('layouts.type200.main')

@section('styles')
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
        <div class="card-body bgletter">
            <div class="row mt-5 mb-3">
                <div class="col-md-12">
                    <div style="padding-left:100px;">
                        To,<div style="float: right;padding-right:100px;"> Dated : {{$hr_grievance->created_at ?
                            $hr_grievance->created_at->format('d M Y') : ''}}</div><br />
                        Grievance Resolving Oficer, <br />
                        {{ $hr_grievance->office() }},Public Works Department, <br />
                        Uttarakhand. <br />
                        <br />
                        <b> Subject </b> : {{ $hr_grievance->grievanceType->name }}, &nbsp; {{ $hr_grievance->subject }}
                        @if($hr_grievance->refference_grievance_id)
                        <a class="btn btn-warning btn-sm"
                            href="{{route('employee.hr_grievance.show', ['hr_grievance' => $hr_grievance->refference_grievance_id])}}">
                            View Previous Linked Grievance </a>
                        @endif
                        <br />
                        <br />
                        <p style="padding-left: 70px;"> {{ $hr_grievance->description }} </p>
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
                                    <a href="{{ route('employee.hr_grievance.doclist', ['hr_grievance'=>$hr_grievance->id, 
                                    'is_question' => 1]) }}"> View Uploaded Documents </a>
                                </p>
                            </div>
                        </div>
                        @endif
                        <hr />
                        <br />
                        <div class="row">
                            <div class="col-md-12">
                                <p> View Draft for Resolving Grievance / ?????????????????? ?????? ????????????????????? ?????????????????? (?????????????????????) : </p>
                                <h6> @if($hr_grievance->draft_answer)
                                    {!! $hr_grievance->draft_answer !!}
                                    @else
                                    Draft Answer Not Yet Received
                                    @endif
                                </h6>
                            </div>
                        </div>

                        <form action="{{ route('hr_grievance.resolveGrievance') }}" method="POST"
                            onsubmit="return confirm('Resolvance Given are correct to my knowledge. ( ????????????????????? ?????????????????? ?????? ?????????????????? ?????? ????????? ???????????? ?????????  ) ??? ');">
                            @csrf
                            <br />
                            <div class="row">
                                <div class="col-md-4">
                                    <p> Add Final Answer for Resolving Grievance /
                                        ?????????????????? ?????? ????????????????????? ?????????????????? : </p>
                                </div>
                                <div class="col-md-7">
                                    <textarea class="form-control" id="final_answer" rows="3" name="final_answer"
                                        required>{{ old('final_answer', '') }}</textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="box-footer justify-content-between">
                                            <input type="submit" confirm("Press a button!"); id="btnAddRegDetails"
                                                class="btn btn-primary"
                                                value="Resolve Grievance ( ?????????????????? ?????? ??????????????????  ???????????? )" </button>
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