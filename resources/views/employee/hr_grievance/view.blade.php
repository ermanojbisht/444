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
                                {{Auth::User()->name}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="grievance_type_id" class="form-label required"> Employee Id ( शिकायतकर्ता की ई०  डी० ) </label>
                            </div>
                            <div class="col-md-6">
                                {{Auth::User()->id}}
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

                <br />
                <div class="text-medium-emphasis small">
                    <input type="hidden" id="employee_id" name="employee_id" value="{{Auth::User()->id}}">
                </div>

                {{-- if has history  --}}

            </div>
        </div>
    </div>
    <br />

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