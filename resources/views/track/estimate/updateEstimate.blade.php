@extends('layouts.type200.main')


@section('headscripts')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .select2-selection select2-selection--single {
        height: 38px !important;
    }
</style>

@endsection

@section('sidebarmenu')
    @include('layouts.type200._commonpartials._sidebarmenu',['instance_estimate_id'=>$estimate->id??0, 'instance_id'=>$estimate->instance_id])
@endsection

@section('pagetitle')
     {{$reportTitle}}
@endsection

@section('breadcrumbNevigationButton')
    @include('layouts._commonpartials._breadcrumbNavbar',
                ['instance_estimate_id'=>$estimate->id??0, 'instance_id'=>$estimate->instance_id])
@endsection

@section('breadcrumb')
    @include('layouts._commonpartials._breadcrumb',
        ['datas'=> [
            ['label'=>'My Estimates','active'=>false],
            ['label'=>'Estimete ID- '.$estimate->id,'active'=>false],
            ['label'=>$reportTitle,'active'=>true],
                    ]  
        ])
@endsection

@section('content')

{{-- @include("track.estimate.partial._EstimateInfo",[ 'instance' => $estimate->instance, 'addDetails' => false ]) --}}
{{-- <x-track.instance-estimate-header :instanceEstimate="$instanceEstimate" pagetitle="Estimate Feature/provision List"
                                      toBackroutename="track.estimate.view"
                                      :routeParameter="['instance_estimate'=>$instanceEstimate->id]"
                                      routelabel="Back to Estimate Tracking Details"/> --}}

<div class="container-fluid">
    <form action="{{ route('estimate.updateEstimate') }}" method="POST">
        @csrf

        <div class="card callout callout-info">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            @if($isEditable)
                            <label for="instance_Name" class="form-label card-title required">Estimate Name </label>
                            <textarea type="text" rows="1" class="form-control" id="instance_Name" name="instance_Name"
                                placeholder="Instance Name" required>{{ old('instance_Name') ?  old('instance_Name') : $estimate->instance->instance_name }}
                            </textarea>
                            @else
                            <label class="form-label card-title "> Estimate Name </label> <br />
                            {{$estimate->instance->instance_name}}
                            <input type="hidden" name="instance_Name" value="{{$estimate->instance->instance_name}}" />
                            @endif

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            @if($isEditable)
                            <label for="ee_office_id" class="form-label card-title  required">EE Office </label>
                            <select class="form-select select2" id="ee_office_id" name="ee_office_id" required>
                                <option value="">select EE Office</option>
                                @foreach($eeOffices as $eeOffice)
                                <option value="{{$eeOffice->id}}" {{ ($eeOffice->id == $estimate->ee_office_id) ?
                                    'selected' : '' }}>
                                    {{$eeOffice->name}} </option>
                                @endforeach
                            </select>
                            @else
                            <label class="form-label card-title">EE Office </label> <br />
                            {{$estimate->officeName->name}}
                            <input type="hidden" name="ee_office_id" value="{{$estimate->ee_office_id}} " />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            @if($isEditable)
                            <label for="district_id" class="form-label card-title  required">District </label>
                            <select class="form-select" id="district_id" name="district_id"
                                onchange="getSetectedBlocks()" required>
                                <option value="">select District</option>
                                @foreach($districts as $district)
                                <option value="{{$district->id}}" {{ (old('district_id')) ?
                                    (old('district_id')==$district->id) ? 'selected' : '' :
                                    ($district->id == $estimate->district_id) ? 'selected' : '' }}>
                                    {{$district->name}} </option>
                                @endforeach
                            </select>
                            @else
                            <label class="form-label card-title"> District </label> <br />
                            {{$estimate->district->name }}
                            <input type="hidden" name="district_id" value="{{$estimate->district_id}} " />
                            @endif

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            @if($isEditable)
                            <label for="block_id" class="form-label card-title required">Block </label> <br />
                            <select class="form-select select2" id="block_id" name="block_id[]" multiple="multiple"
                                required>
                                @foreach($all_district_blocks as $key => $value)
                                <option value="{{$key}}" {{ (in_array($key, old('block_id', [])) || $instance_blocks->
                                    contains($value)) ? 'selected' : '' }}>
                                    {{$value}}
                                </option>
                                @endforeach
                            </select>
                            @else
                            <label class="form-label card-title"> Block </label> <br />
                            <label class="form-label">
                                @foreach($instance_blocks as $value)
                                {{$value}}
                                @endforeach
                            </label>
                            <input type="hidden" name="block_id[]" value="{{$estimate->block_id}} " />
                            @endif

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            @if($isEditable)
                            <label for="constituency_id" class="form-label card-title  required">Constituency
                            </label><br />
                            <select class="form-select select2" id="constituency_id" name="constituency_id[]"
                                multiple="multiple" required>
                                @foreach($all_district_constituencies as $key => $value)
                                <option value="{{$key}}" {{ (in_array($key, old('constituency_id', [])) ||
                                    $instance_constituencies->contains($value)) ? 'selected' : '' }}>
                                    {{$value}}
                                </option>
                                @endforeach

                            </select>
                            @else
                            <label class="form-label card-title"> Constituency </label> <br />
                            <label class="form-label" name="constituency_id">
                                @foreach($instance_constituencies as $value)
                                {{$value}}
                                @endforeach
                            </label>
                            <input type="hidden" name="constituency_id[]" value="{{$estimate->constituency_id}} " />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            @if($isEditable)
                            <label for="loksabha_id" class="form-label card-title required">Lok Sabha </label>
                            <select class="form-select " id="loksabha_id" name="loksabha_id" required>
                                <option value="">select Loksabha</option>
                                @foreach($Loksabhas as $loksabha)
                                <option value="{{$loksabha->id}}" {{ (old('loksabha_id')) ?
                                    (old('loksabha_id')==$loksabha->id) ? 'selected' : '' :
                                    ($loksabha->id == $estimate->loksabha_id) ? 'selected' : '' }}> {{$loksabha->name}}
                                </option>
                                @endforeach
                            </select>
                            @else
                            <label class="form-label card-title"> Lok Sabha </label> <br />
                            {{$estimate->loksabha->name}}
                            <input type="hidden" name="loksabha_id" value="{{$estimate->loksabha_id}} " />
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="estimate_cost" class="form-label card-title required">Estimate Cost (In
                                Lakhs)</label>
                            <input type="number" step="0.001" class="form-control" id="estimate_cost"
                                name="estimate_cost" placeholder="Estimate Cost"
                                value="{{ old('estimate_cost') ?  old('estimate_cost') : $estimate->estimate_cost}}"
                                required maxlength="6" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="worktype_id" class="form-label card-title required">Work Type </label>
                            <select class="form-select" id="worktype_id" name="worktype_id" required>
                                <option value="">select work Type </option>
                                @foreach($workType as $work)
                                <option value="{{$work->id}}" {{ (old('worktype_id')) ? (old('worktype_id')==$work->id)
                                    ? 'selected' : '' :
                                    ($work->id == $estimate->worktype_id) ? 'selected' : '' }} >
                                    {{$work->name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="due_to" class="form-label card-title required">Due To </label>
                            <select class="form-select" id="due_to" name="due_to" required>
                                <option value="">select..</option>
                                @foreach(config('mis_entry.estimate.due_to') as $key => $value)
                                <option value="{{$key}}" {{ (old('due_to')) ? (old('due_to')==$key) ? 'selected' : '' :
                                    ($estimate->due_to == $key) ? 'selected' : '' }}>
                                    {{$value}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reference_no" class="form-label card-title">Reference No </label>
                            <textarea rows="1" class="form-control" id="reference_no" name="reference_no"
                                maxlength="250">{{ old('reference_no') ? old('reference_no') : $estimate->reference_no}} 
                            </textarea>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label card-title" for="road_length">Road Length in KM</label>
                            <input type="number" step="0.001" class="form-control" name="road_length"
                                placeholder="Road Length"
                                value="{{ old('road_length') ? old('road_length') : $estimate->road_length}}"
                                maxlength="4" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label card-title"> Bridge No </label>
                            <input type="number" class="form-control" name="bridge_no" maxlength="2"
                                placeholder="Bridge No"
                                value="{{ old('bridge_no') ? old('bridge_no') : $estimate->bridge_no}}" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label card-title" for="bridge_span">Bridge Span in meter</label>
                            <input type="number" step="0.001" class="form-control" name="bridge_span"
                                placeholder="Bridge span" maxlength="3"
                                value="{{ old('bridge_span') ? old('bridge_span') : $estimate->bridge_span}}" />
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label card-title"> Building No </label>
                            <input type="number" class="form-control" name="building_no" maxlength="2"
                                placeholder="Building No"
                                value="{{ old('building_no') ? old('building_no') : $estimate->building_no}}" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label card-title" for="other_Remark"> Remarks </label>
                            <textarea type="text" class="form-control" rows="1" id="other_Remark" name="other_Remark"
                                placeholder="Remark">{{ old('other_Remark') ?  old('other_Remark') : $estimate->other_Remark}} 
                             </textarea>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            @if($isEditable)
                            <label class="form-label card-title"> Work Code </label>
                            <input type="text" class="form-control" name="WORK_code" placeholder="WORK Code"
                                value="{{ old('WORK_code') ?  old('WORK_code') : $estimate->WORK_code}}" />
                            @else
                            <label class="form-label card-title"> Work Code </label> <br />
                            <label name="WORK_code"> {{$estimate->WORK_code}} </label>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group  card-title">
                            <label> Objective </label>
                            <textarea rows="3" type="text" class="form-control" rows="1" id="objective" name="objective"
                                placeholder="Objective">{{ old('objective') ?  old('objective') : $estimate->objective}}</textarea>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group  card-title">
                            <label> Connectivity Status </label>
                            <textarea rows="3" type="text" class="form-control" rows="1" id="connectivity_status"
                                name="connectivity_status"
                                placeholder="Connectivity Status">{{ old('connectivity_status') ?  old('connectivity_status') : $estimate->connectivity_status}}  </textarea>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group  card-title">
                            <label> Villages </label>
                            <textarea rows="3" type="text" class="form-control" rows="2" id="villages" name="villages"
                                placeholder="villages">{{ old('villages') ?  old('villages') : $estimate->villages}} </textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <br />
                            <div class="box-footer justify-content-between">
                                <input type="hidden" name="instance_id" value="{{ $estimate->instance->id }}" />

                                <button id="btnAddRegDetails" type="submit" class="btn btn-info">
                                    Update Estimate </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('footscripts')

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script type="text/javascript">
    $( document ).ready(function() {
       // getSetectedBlocks(true);    
    });

    var placeholder = "Select District First";
    $(".select2" ).select2({
        placeholder: placeholder,
        containerCssClass: '  form-control'
    });

    $(".select2 " ).on( "select2:open", function() {
        if($( this ).parents( "[class*='has-']" ).length ) {
            var classNames = $( this ).parents( "[class*='has-']" )[ 0 ].className.split( /\s+/ );
            for(var i = 0; i < classNames.length; ++i ) {
                if ( classNames[ i ].match( "has-" ) ) {
                    $( "body > .select2-container" ).addClass( classNames[ i ] );
                }
            }
        }
    });


    function getSetectedBlocks(isupdate)
    {
        if(isupdate)
            district = {{$estimate->district_id}}; 
        else
            district = $("#district_id").val();

        var _token = $('input[name="_token"]').val();
        if (district > 0) {
            $.ajax({
                url: "{{ route('getBlocksInDistrict') }}",
                method: "POST",
                data: {
                    district: district,
                    _token: _token
                },
                success: function(data) {
                    bindDdlWithData("block_id", data, "id", "name", true, "0", "Select Block", {{$estimate->district_id}});
                     $('#block_id').val("");
                    getSetectedConstituency();
                }
            });
        }
    }

    function getSetectedConstituency()
    {
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
                success: function(data) {
                    bindDdlWithData("constituency_id", data, "id", "name", true, "0", "Select Constituency" , {{$estimate->district_id}});
                      $('#constituency_id').val("");
                }
            });
        }
    }
    
</script>


@include('partials.js._dropDownJs')

@include('partials.js._makeDropDown')

@endsection
