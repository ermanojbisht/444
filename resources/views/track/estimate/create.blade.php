@extends('layouts.type200.main')


@section('headscripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('sidebarmenu')
    @include('layouts.type200._commonpartials._sidebarmenu',['active'=>'create_Instance'])
@endsection

@section('pagetitle')
     Add Basic Details
@endsection

@section('breadcrumb')
    @include('layouts._commonpartials._breadcrumb',
        [   'datas'=> [
                        ['label'=>'Estimate','active'=>false],
                        ['label'=>'Estimate ID- '.$instance->id,'active'=>false],
                        ['label'=>'Add Basic Details','active'=>true],
                    ]  
        ])
@endsection


@section('content')

<form action="{{ route('estimate.store') }}" method="POST">
    @csrf
    @include("track.estimate.partial._EstimateInfo",[ 'instance' => $instance, 'addDetails' => false ])
    
    <div class="container-fluid">
        <div class="card callout callout-info">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="ee_office_id" class="form-label required">EE Office </label>
                            <select class="form-select select2" id="ee_office_id" name="ee_office_id" required>
                                <option value="">select EE Office</option>
                                @foreach($eeOffices as $eeOffice)
                                <option value="{{$eeOffice->id}}" {{ old('ee_office_id')==$eeOffice->id ? 'selected' :
                                    '' }}> {{$eeOffice->name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="district_id" class="form-label required">District </label>
                            <select class="form-select" id="district_id" name="district_id"
                                onchange="getSetectedBlocks()" required>
                                <option value="">select District</option>
                                @foreach($districts as $district)
                                <option value="{{$district->id}}" {{ old('district_id')==$district->id ? 'selected' : ''
                                    }}> {{$district->name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="block_id" class="form-label required">Block </label> <br />
                            <select class="form-select select2" id="block_id" name="block_id[]" multiple="multiple"
                                required>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="constituency_id" class="form-label required">Constituency </label><br />
                            <select class="form-select select2" id="constituency_id" name="constituency_id[]"
                                multiple="multiple" required>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="loksabha_id" class="form-label required">Lok Sabha </label>
                            <select class="form-select " id="loksabha_id" name="loksabha_id" required>
                                <option value="">select Loksabha</option>
                                @foreach($Loksabhas as $loksabha)
                                <option value="{{$loksabha->id}}" {{ old('loksabha_id')==$loksabha->id ? 'selected' : ''
                                    }}> {{$loksabha->name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <br />
                <div class="row">


                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="worktype_id" class="form-label required">Work Type </label>
                            <select class="form-select" id="worktype_id" name="worktype_id" required>
                                <option value="">select work Type</option>
                                @foreach($workType as $work)
                                <option value="{{$work->id}}" {{ old('worktype_id')==$work->id ? 'selected' : '' }}>
                                    {{$work->name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="estimate_cost" class="form-label required">Estimate Cost (In Lakhs)</label>
                            <input type="number" step="0.001"  class="form-control" id="estimate_cost" name="estimate_cost"
                                value="{{ old('estimate_cost', '') }}" placeholder="Estimate Cost" required
                                maxlength="6" />
                        </div>
                    </div>


                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="due_to" class="form-label required">Due To </label>
                            <select class="form-select" id="due_to" name="due_to" required>
                                <option value="">select..</option>
                                @foreach(config('mis_entry.estimate.due_to') as $key => $value)
                                <option value="{{$key}}" {{ old('due_to')==$key ? 'selected' : '' }}> {{$value}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reference_no" class="form-label">Reference No </label>
                            <textarea rows="1" class="form-control" id="reference_no" name="reference_no"
                                maxlength="250" value="{{ old('reference_no', '') }}"></textarea>
                        </div>
                    </div>

                </div>
                <hr>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="road_length">Road Length in KM</label>
                            <input type="number" step="0.001"  class="form-control" name="road_length" maxlength="4"
                                placeholder="Road Length" value="{{ old('road_length', '') }}" />
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label> Bridge No </label>
                            <input type="number" class="form-control" name="bridge_no" maxlength="2"
                                placeholder="Bridge No" value="{{ old('bridge_no', '') }}" />
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="bridge_span">Bridge Span in meter</label>
                            <input type="number" step="0.001" class="form-control" name="bridge_span" maxlength="3"
                                placeholder="Bridge span" value="{{ old('bridge_span', '') }}" />
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label> Building No </label>
                            <input type="number" class="form-control" name="building_no" maxlength="2"
                                placeholder="Building Numbers" value="{{ old('building_no', '') }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="other_Remark"> Remarks </label>
                            <textarea rows="1" type="text" class="form-control" rows="2" id="other_Remark"
                                name="other_Remark" placeholder="Remarks"> {{ old('building_no', '') }} </textarea>
                        </div>
                    </div>

                </div>

                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label card-title"> Work Code </label>
                            <input type="text" class="form-control" name="WORK_code" placeholder="WORK Code"
                                value="{{ old('WORK_code', '') }}" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group  card-title">
                            <label> Objective </label>
                            <textarea rows="3" type="text" class="form-control" rows="1" id="objective" name="objective"
                                placeholder="Objective">  {{ old('Objective', '') }}  </textarea>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group  card-title">
                            <label> Connectivity Status </label>
                            <textarea rows="3" type="text" class="form-control" rows="1" id="connectivity_status"
                                name="connectivity_status"
                                placeholder="Connectivity Status"> {{ old('connectivity_status', '') }}  </textarea>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group  card-title">
                            <label> Villages </label>
                            <textarea rows="3" type="text" class="form-control" rows="2" id="villages" name="villages"
                                placeholder="villages"> {{ old('villages', '') }}  </textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="box-footer justify-content-between">
                                <input type="hidden" name="instance_id" value="{{ $instance->id }}" />

                                <button id="btnAddRegDetails" type="submit" class="btn btn-info">
                                    Add Estimate Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
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
            containerCssClass: '  form-control'
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


        function getSetectedBlocks() {
            var district = $("#district_id").val();
            // alert(district);
            var _token = $('input[name="_token"]').val();
            if (district > 0) {
                $.ajax({
                    url: "{{ route('getBlocksInDistrict') }}",
                    method: "POST",
                    data: {
                        district: district,
                        _token: _token
                    },
                    success: function (data) {
                        bindDdlWithData("block_id", data, "id", "name", true, "0", "Select Block");
                        $('#block_id').val("");

                        getSetectedConstituency();
                    }
                });
            }
        }

        function getSetectedConstituency() {
            var district = $("#district_id").val();
            var _token = $('input[name="_token"]').val();
            if (district > 0) {
                $.ajax({
                    url: "{{ route('getConstituenciesInDistrict') }}",
                    method: "POST",
                    data: {
                        district: district,
                        _token: _token
                    },
                    success: function (data) {
                        bindDdlWithData("constituency_id", data, "id", "name", true, "0", "Select Constituency");
                        $('#constituency_id').val("");
                    }
                });
            }
        }


</script>


@include('partials.js._dropDownJs')

@include('partials.js._makeDropDown')

@endsection
