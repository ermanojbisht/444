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
    ['label'=> 'Edit','active'=>true],
    ]])
@endsection


@section('content')

<form action="{{ route('employee.hr_grievance.update') }}" method="POST"
    onsubmit="return confirm('Above Written Details are correct to my knowledge. ( उपरोक्त समस्या एवं डॉक्यूमेंट के प्रपत्र से में सहमत हूँ  ) ??? ');">
    @csrf

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

                        <div class="col-md-6">
                            <label for="grievance_type_id" class="form-label required"> Employee Id (शिकायतकर्ता की ई०
                                डी० ) </label>
                            {{Auth::User()->id}}
                        </div>
                        <div class="col-md-6">
                            <label for="grievance_type_id" class="form-label required"> Employee Name (शिकायतकर्ता का
                                नाम)* </label>
                            {{Auth::User()->name}}
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
                    <div class="col-md-4   ">
                        <label for="grievance_type_id" class="form-label required"> Grievance Type ( शिकायत का प्रकार)
                        </label>
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" id="grievance_type_id" name="grievance_type_id" required>
                            <option value="0"> Select Grievance Type </option>
                            @foreach($grievanceTypes as $grievance )
                            <option value="{{$grievance->id}}" {{ $hr_grievance->grievance_type_id == $grievance->id ? 'selected' : '' }} > {{$grievance->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4  ">
                        <label for="office_type" class="form-label required"> Office Type ( ऑफिस का प्रकार) </label>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="form-select" id="office_type" name="office_type" required
                                onchange="getSetectedOffices()">
                                <option value="0" {{ $hr_grievance->office_type == 0 ? 'selected' : '' }}>EnC Ofice
                                </option>
                                <option value="1" {{ $hr_grievance->office_type == 1 ? 'selected' : '' }}>Zone</option>
                                <option value="2" {{ $hr_grievance->office_type == 2 ? 'selected' : '' }} >Circle
                                </option>
                                <option value="3" {{ $hr_grievance->office_type == 3 ? 'selected' : '' }} >Division
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4  ">
                        <label for="office_id" class="form-label required"> Office ( ऑफिस ) </label>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="form-select select2" id="office_id" name="office_id" required>
                                <option value="">select Office</option>

                                @if($hr_grievance->office_id)


                                @foreach($eeOffices as $key=>$eeOffice)
                                <option value="{{ $eeOffice->id }}" @if($hr_grievance->office_id == $eeOffice->id) selected @endif
                                    >{{ $eeOffice->name }}</option>
                                @endforeach

                                @else

                                <option value="0" selected > ENC Office</option>

                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 ">
                        <label for="description" class="form-label  required"> Description of Grievance ( शिकायत का
                            संछिप्त सार)
                        </label>
                    </div>
                    <div class="col-md-6">
                        <textarea class="form-control" id="description" rows="3"
                            name="description">{{ $hr_grievance->description }}</textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">

                        <div class="form-check">
                            <input class="form-check-input" id="invalidCheck" type="checkbox" required="">
                            <label class="form-check-label" for="invalidCheck"> Above Written Details are correct to my
                                knowledge. ( उपरोक्त शिकायत एवं डॉक्यूमेंट के प्रपत्र से में सहमत हूँ | ) </label>
                            <div class="invalid-feedback">You must agree before submitting.</div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="box-footer justify-content-between">
                                <input type="submit" confirm("Press a button!"); id="btnAddRegDetails"
                                    class="btn btn-primary" value="Update Grievance ( शिकायत / मांग / सुझाव सुधारें )"
                                    </button>

                                <input type="hidden" id="employee_id" name="employee_id" value="{{Auth::User()->id}}">
                                <input type="hidden" id="grievance_id" name="grievance_id" value="{{ $hr_grievance->id }}">

                            </div>
                        </div>
                    </div>
                </div>

                <br />
                <div class="text-medium-emphasis small">
                    Note: <br />
                    This Grievance is editable for {{config('site.backdate.hrGrievance.allowedno')}} days.
                    ( शिकायत जमा करने के, केवल {{config('site.backdate.hrGrievance.allowedno')}} दिनों तक ही सुधर किया जा
                    सकेगा | )<br />
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
            containerCssClass: 'form-control'
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
            let _token = $('input[name="_token"]').val();
            //if (officeType > 0) {
                $.ajax({
                    url: "{{ route('employee.ajaxDataForOffice') }}",
                    method: "POST",
                    data: {
                        officeType : officeType,
                        _token : _token
                    },
                    success: function (data) {
                        bindDdlWithDataAndSetValue("office_id", data, "id", "name", true, "0", "Select Office", "");
                    }
                });
            //}
        }


</script>

{{-- @include('partials.js._dropDownJs') --}}

@include('partials.js._makeDropDown')

@endsection