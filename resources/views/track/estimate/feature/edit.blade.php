@extends('layouts.type200.main')
{{-- @extends('layouts.type100.main') --}}

@section('sidebarmenu')
    @include('layouts.type200._commonpartials._sidebarmenu',['instance_estimate_id'=>$instanceEstimate->id??0])
@endsection

@section('content')

<div class="container-fluid">
<x-track.instance-estimate-header :instanceEstimate="$instanceEstimate" pagetitle="Edit Estimate Feature/provision"
                                      toBackroutename="instanceEstimate.instanceEstimateFeature.index"
                                      :routeParameter="['instanceEstimate'=>$instanceEstimate->id]"
                                      routelabel="Back to Estimate Feature list"/>

    <div class="col-sm-12">
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body card-block">
            {{-- form --}}
            <form action="{{ route('instanceEstimate.instanceEstimateFeature.update',[$instanceEstimate->id,$instanceEstimateFeature->id]) }}" method="post" enctype="multipart/form-data" class="">
                @method('PUT')
                {{ csrf_field() }}
                <div class="row">
                {{-- estimate_group_id --}}
                <div class="form-group col-md-6 {{ $errors->has('estimate_group_id') ? ' has-error' : '' }} ">
                    <label class="required">Estimate's Sub Group</label>
                    <select id="estimate_group_id" name="estimate_group_id" class="form-control required" >
                        <option value="">Select Estimate's Sub Group</option>
                        @foreach($estimateGroups as $key=>$estimateGroup)
                            <option value="{{ $key }}"
                                {{(old('estimate_group_id') ? old('estimate_group_id') : $instanceEstimateFeature->estimate_group_id ?? '')==$key? 'selected':''}} >
                                {{ $estimateGroup }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('estimate_group_id'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('estimate_group_id') }}</strong>
                    </span>
                    @endif
                </div>
                {{-- estimate_feature_group --}}
                <div class="form-group col-md-6 {{ $errors->has('estimate_feature_group') ? ' has-error' : '' }} ">
                    <label class="required">Feature/Provision Group</label>
                    <select id="estimate_feature_group" name="estimate_feature_group" class="form-control required" onchange="getFeatureListAsPerSelectedGroup({sourceElementId:'estimate_feature_group',routeIdentifier:'estimate_feature_group',ddlId:'estimate_feature_type_id',blankRowTextField:'Select feature '})">
                        <option value="">Select Feature Group</option>
                        @foreach($estimateFeatureGroups as $estimateFeatureGroup)
                            <option value="{{ $estimateFeatureGroup->id }}"
                                {{(old('estimate_feature_group') ? old('estimate_feature_group') : $lastAddedFeatureGroup ?? '')==$estimateFeatureGroup->id? 'selected':''}} >
                                {{ $estimateFeatureGroup->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('estimate_feature_group'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('estimate_feature_group') }}</strong>
                    </span>
                    @endif
                </div>
                {{-- estimate_feature_type_id --}}
                <div class="form-group col-md-12 {{ $errors->has('estimate_feature_type_id') ? ' has-error' : '' }} ">
                    <label class="required">Feature/Provision</label>
                    <select id="estimate_feature_type_id" name="estimate_feature_type_id" class="form-control required" size="1">
                        <option value="">Select Feature</option>
                        @foreach($estimateFeatureTypes as $estimateFeatureType)
                            <option value="{{ $estimateFeatureType->id }}" {{ (old('estimate_feature_type_id') ? old('estimate_feature_type_id') : $instanceEstimateFeature->estimate_feature_type_id ?? '')==$estimateFeatureType->id? 'selected':'' }}>{{ $estimateFeatureType->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('estimate_feature_type_id'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('estimate_feature_type_id') }}</strong>
                    </span>
                    @endif
                </div>
                {{-- rate --}}
                <div class="form-group col-md-2 {{ $errors->has('rate') ? ' has-error' : '' }}">
                    <label class="required">rate  in lakhs</label>
                    <input type="number" name="rate" class="form-control required" value="{{ old('rate', $instanceEstimateFeature->rate) }}" step="0.001" required>
                    @if ($errors->has('rate'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('rate') }}</strong>
                    </span>
                    @endif
                </div>
                {{-- qty --}}
                <div class="form-group col-md-2 {{ $errors->has('qty') ? ' has-error' : '' }}">
                    <label class="required">qty</label>
                    <input type="number" name="qty" class="form-control required" value="{{ old('qty', $instanceEstimateFeature->qty) }}" step="0.001" required>
                    @if ($errors->has('qty'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('qty') }}</strong>
                    </span>
                    @endif
                </div>
                {{-- cost --}}
                <div class="form-group col-md-2 {{ $errors->has('cost') ? ' has-error' : '' }}">
                    <label class="required">cost  in lakhs</label>
                    <input type="number" name="cost" class="form-control required" value="{{ old('cost', $instanceEstimateFeature->cost) }}" step="0.001" required>
                    @if ($errors->has('cost'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('cost') }}</strong>
                    </span>
                    @endif
                </div>

                {{-- remark --}}
                <div class="form-group col-md-6 {{ $errors->has('remark') ? ' has-error' : '' }}">
                    <label for="remark">Remark</label>
                    <span class="help-block text-success pull-right">
                        <small>* Remark should be short </small>
                    </span>
                    <input type="text" name="remark" class="form-control" value="{{ old('remark', $instanceEstimateFeature->remark) }}">
                    @if ($errors->has('remark'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('remark') }}</strong>
                    </span>
                    @endif
                </div>

                </div>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="saveBtn" class="btn btn-flat btn-primary pull-right">Save</button>
            </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    </div>

@endsection
@section('footscripts')
<script type="text/javascript">
    window.onload = function() {
        getFeatureListAsPerSelectedGroup({
            sourceElementId: 'estimate_feature_group',
            routeIdentifier: 'estimate_feature_group',
            ddlId: 'estimate_feature_type_id',
            value_to_be_selected: {{$instanceEstimateFeature->estimate_feature_type_id??0}},
            blankRowTextField: 'Select feature '
        });
    };
</script>
@include('partials.js._getFeatureListAsPerSelectedGroupJs')

@include('partials.js._dropDownJs')

@include('partials.js._makeDropDown')

@endsection
