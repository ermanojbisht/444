@extends('layouts.type200.main')


@section('headscripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .row {
        padding-bottom: 20px;
    }
</style>
@endsection


@section('pagetitle')
Fill your grievances ( शिकायत निवारण हेतु आवेदन फार्म)
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
['datas'=> [
['label'=> 'Home','active'=>false, 'route'=> 'employee.home'],
['label'=> 'Grievance','active'=>false],
['label'=> 'List','active'=>false, 'route' => 'employee.hr_grievance'],
['label'=> 'Create','active'=>true],
]])
@endsection

@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_hr_gr',['active'=>'Grienvance'])
@endsection



@section('content')

<form action="{{ route('employee.hr_grievance.store') }}" method="POST"
    onsubmit="return confirm('Above Written Details are correct to my knowledge. ( उपरोक्त समस्या एवं डॉक्यूमेंट के प्रपत्र से में सहमत हूँ  ) ??? ');">
    @csrf
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row mt-3 mb-3">
                    <div class="col-md-6">
                        <p class=""> Employee Name (शिकायतकर्ता का नाम) : {{Auth::User()->name}} </p>
                    </div>
                    <div class="col-md-6" style="text-align:right">
                        <p class=""> Employee Id : {{Auth::user()->employee_id}} </p>
                    </div>
                    <hr />
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="grievance_type_id" class="  form-label required"> Grievance Type ( शिकायत का
                            प्रकार)
                        </label>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="grievance_type_id" name="grievance_type_id" required>
                            <option value=""> Select Grievance Type </option>
                            @foreach($grievanceTypes as $grievance )
                            <option value="{{$grievance->id}}" {{ old('grievance_type_id')==$grievance->id ? 'selected'
                                : '' }}> {{$grievance->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <p for="office_id" class=" form-label required"> Grievance Office (शिकायत का ऑफिस ) </p>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-select select2" id="office_id" name="office_id"
                                onchange="getDraftandFinalResolver()" required>
                                <option value="0">select Office</option>
                                @foreach($eeOffices as $key=>$eeOffice)
                                <option {{ old('office_id')==$eeOffice->id ? 'selected' : '' }}
                                    value="{{ $eeOffice->id }}" >{{ $eeOffice->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <label class=" form-label required"> Grievance Resolving Officer (शिकायत निवारण कर्ता आधिकारी )
                            :
                        </label>
                        <label id="lblResolvingOfficer" class=" form-label"> </label>
                        <label id="lblResolvingOfficerEmployeeId" class="hide form-label"> </label>
                    </div>
                </div>

                <br />
                <div class="row">
                    <div class="col-md-3">
                        <p for="subject" class=" form-label required "> Subject ( विषय ) </p>
                        <label class="text-danger"> Not more the 50 Characters </label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="subject" rows="3" minlength="10" maxlength="50"
                            name="subject" required value="{{ old('subject', '') }}"
                            onkeypress="countCharacters(this, 'lbl_subject_counter')"
                            onkeydown="countCharacters(this, 'lbl_subject_counter')"
                            onkeyup="countCharacters(this, 'lbl_subject_counter')" />
                        <label class="text-danger" id="lbl_subject_counter"> 0 </label>
                        <label class="text-danger"> Charcaters </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <p for="description" class=" form-label required "> Description of Grievance
                            ( शिकायत का संछिप्त सार) </p>
                        <label class="text-danger"> Not more the 400 Characters </label>
                    </div>
                    <div class="col-md-9">
                        <textarea class="form-control" id="description" rows="3" minlength="10" maxlength="400"
                            name="description" required onkeypress="countCharacters(this, 'lbl_description_counter')"
                            onkeydown="countCharacters(this, 'lbl_description_counter')"
                            onkeyup="countCharacters(this, 'lbl_description_counter')">{{ old('description', '') }}</textarea>
                        <label class="text-danger" id="lbl_description_counter"> 0 </label>
                        <label class="text-danger"> Charcaters </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <p for="is_document_upload" class=" form-label required"> Do You want to Upload
                            Document (
                            डॉक्यूमेंट अपलोड करने हेतु ) </p>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-select" id="is_document_upload" name="is_document_upload" required>
                                <option value="1" {{ old('is_document_upload')==1 ? 'selected' : '' }}>Yes
                                </option>
                                <option value="0" {{ old('is_document_upload')==0 ? 'selected' : '' }}> NO
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-check required">
                            <input class="form-check-input" id="invalidCheck" name="invalidCheck" type="checkbox"
                                required="">
                            <label class=" form-check-label" for="invalidCheck"> Above Written Details are
                                correct to my
                                knowledge. ( उपरोक्त शिकायत एवं डॉक्यूमेंट के प्रपत्र से में सहमत हूँ | )
                                </span>
                                <div class="invalid-feedback">You must agree before submitting.</div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="box-footer justify-content-between">
                                <input type="submit" confirm("Press a button!"); id="btnAddRegDetails"
                                    class="btn btn-primary" value="Add Grievance ( शिकायत / मांग / सुझाव दर्ज करे)" />

                                <input type="hidden" id="employee_id" name="employee_id"
                                    value="{{Auth::user()->employee_id}}">
                            </div>
                        </div>
                    </div>
                </div>

                <br />
                <div class="text-medium-emphasis small">
                    Note: <br />
                    You can upload related documents in next screen
                    (आप अगली स्क्रीन पर जा कर संबंधित प्रपत्र अपलोड कर सकते हैं | )
                </div>
            </div>
        </div>
    </div>
    <br />
    </div>
</form>
@endsection

@section('footscripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(".select2").select2();
    function countCharacters(thiss, lblShowCounterId)
    {
        $("#" +lblShowCounterId).html(thiss.value.length);
    }

    function getDraftandFinalResolver()
    {
        let office_id = $("#office_id").val();
        let _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('getFinalResolverOfOffice') }}",
            method: "POST",
            data: {
                office_id : office_id,
                _token : _token
            },
            success: function (data) {
               if(data == "") {
                    $("#lblResolvingOfficer").html('<div class="alert alert-danger"><strong>Warning!</strong>Grievance Redressal Officer not appointed in selected office, hence application can not be submitted</div>');
                    $("#lblResolvingOfficerEmployeeId").html('');
                    $("#btnAddRegDetails").attr("disabled", "disabled"); 
                }
                else{
                    $("#lblResolvingOfficer").html(data["name"]);
                    $("#lblResolvingOfficerEmployeeId").html(data["employee_id"]);
                    $("#btnAddRegDetails").removeAttr("disabled"); 
                }
            }
        });
    }

</script>
@include('partials.js._makeDropDown')
@endsection