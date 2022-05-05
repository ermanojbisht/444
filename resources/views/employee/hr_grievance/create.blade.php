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
                    <div class="col-md-4">
                        <label for="grievance_type_id" class="  form-label required"> Grievance Type ( शिकायत का
                            प्रकार)
                        </label>
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" id="grievance_type_id" name="grievance_type_id" required>
                            <option value=""> Select Grievance Type </option>
                            @foreach($grievanceTypes as $grievance )
                            <option value="{{$grievance->id}}" {{ old('grievance_type_id')==$grievance->id ? 'selected'
                                :
                                '' }}> {{$grievance->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">


                    <fieldset>
                        <legend>Select Office who will resolve your grievance :</legend>

                        <div class="row">
                            <div class="col-md-4">
                                <p for="office_type" class=" form-label required"> Office Type ( ऑफिस का प्रकार)
                                </p>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-select" id="office_type" name="office_type" required
                                        onchange="getSetectedOffices()">
                                        <option value="0">EnC Ofice</option>
                                        <option value="1">Zone</option>
                                        <option value="2">Circle</option>
                                        <option value="3" selected>Division </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <p for="office_id" class=" form-label required"> Office ( ऑफिस ) </p>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-select select2" id="office_id" name="office_id" required>
                                        <option value="">select Office</option>
                                        @foreach($eeOffices as $office)
                                        <option value="{{$office->id}}" {{ old('office_id')==$office->id ?
                                            'selected' : ''
                                            }}>
                                            {{$office->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                    </fieldset>

                    <div> <br /> </div>
                    <div class="row">
                        <div class="col-md-4">
                            <p for="description" class=" form-label required "> Subject ( विषय ) </p>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="subject" rows="3" minlength="10" name="subject"
                                required value="{{ old('subject', '') }}  " />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <p for="description" class=" form-label required "> Description of Grievance
                                ( शिकायत का संछिप्त सार) </p>
                        </div>
                        <div class="col-md-6">
                            <textarea class="form-control" id="description" rows="3" minlength="10" name="description"
                                required>{{ old('description', '') }} </textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <p for="is_document_upload" class=" form-label required"> Do You want to Upload
                                Document (
                                डॉक्यूमेंट अपलोड करने हेतु ) </p>
                        </div>
                        <div class="col-md-6">
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
                                <input class="form-check-input" id="invalidCheck" type="checkbox" required="">
                                <span class=" form-check-label" for="invalidCheck"> Above Written Details are
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
                                        class="btn btn-primary" value="Add Grievance ( शिकायत / मांग / सुझाव दर्ज करे)"
                                        </button>
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
    var placeholder = "Select District First";

        $(".select2").select2({
            placeholder: placeholder,
            containerCssClass: 'form-control',
            autowidth: true
        });

        $(".select2 ").on("select2:open", function () {
            if ($(this).parents("[class*='has-']").length) {
                var classNames = $(this).parents("[class*='has-']")[0].className.split(/\s+/);
                for (var i = 0; i < classNames.length; ++i) {
                    if (classNames[i].match("has-")) {
                        $("body > .select2-container").addClass(classNames[i]);
                    }
                }
            }
        });

        function getSetectedOffices() {
            let officeType = $("#office_type").val();
            let _token = $('input[name="_token"]').val(); //if (officeType > 0) {
                $.ajax({
                    url: "{{ route('employee.ajaxDataForOffice') }}",
                    method: "POST",
                    data: {
                        officeType : officeType,
                        _token : _token
                    },
                    success: function (data) {
                        bindDdlWithDataAndSetValue("office_id", data, "id", "name", true, "", "Select Office", "");
                    }
                }); //}
        }


</script>

{{-- @include('partials.js._dropDownJs') --}}

@include('partials.js._makeDropDown')

@endsection