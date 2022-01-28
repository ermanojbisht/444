{{-- @extends('layouts.type100.main') --}}
@extends('layouts.type200.main')


@section('headscripts')
    <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
@endsection


@section('sidebarmenu')
    @include('layouts.type200._commonpartials._sidebarmenu',['instance_estimate_id'=>$instanceEstimate->id??0, 'instance_id'=>$instanceEstimate->instance_id])
@endsection

@section('pagetitle')
     {{$reportTitle}}
@endsection

@section('breadcrumbNevigationButton')
    @include('layouts._commonpartials._breadcrumbNavbar',
                ['instance_estimate_id'=>$instanceEstimate->id??0, 'instance_id'=>$instanceEstimate->instance_id])
@endsection

@section('breadcrumb')
    @include('layouts._commonpartials._breadcrumb',
        ['datas'=> [
            ['label'=>'Estimete','active'=>false],
            ['label'=>'Estimete ID- '.$instanceEstimate->id,'active'=>false],
            ['label'=>$reportTitle,'active'=>true],
                    ]  
        ])
@endsection

@section('content')

   {{--  @include("track.estimate.partial._EstimateInfo",[
            'instance' => $instance,
            'addDetails' => true,
            'instanceEstimate' => $instanceEstimate,
            'blocks' => $instance_blocks,
            'Constituencies' => $instance_constituencies
            ]) --}}

<div class="container-fluid">
    <div class="card callout callout-info">
        <div class="card-body">
            <form action="{{ route('estimate.updateEstimateDetails') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group ">
                            <label class="card-title"> New Work Code </label> {{$instanceEstimate->new_WORK_Code }}
                            <input type="text" class="form-control" name="new_WORK_Code" placeholder="New WORK Code"
                                value="{{$instanceEstimate->new_WORK_Code}}" />
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            @if($isEditable)
                            <label class="card-title"> Completion Months </label>
                            <input type="number" maxlength="4" class="form-control" name="completion_months"
                                placeholder="Completion Months" value="{{$instanceEstimate->completion_months}}" />
                            @else
                            <label class="card-title"> Completion Months </label> <br />
                            {{$instanceEstimate->completion_months}}
                            <input type="hidden" name="completion_months"
                                value="{{$instanceEstimate->completion_months}} " />
                            @endif
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            @if($isEditable)
                            <label class="card-title"> TSC Cost </label>
                            <input type="number" step="0.001" maxlength="10" class="form-control" name="tsc_cost"
                                placeholder=" TSC Cost " value="{{$instanceEstimate->tsc_cost}}" />
                            @else
                            <label class="card-title"> TSC Cost </label> <br />
                            {{$instanceEstimate->tsc_cost}}
                            <input type="hidden" name="tsc_cost" value="{{$instanceEstimate->tsc_cost}} " />
                            @endif
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            @if($isEditable)
                            <label class="card-title"> TA Cost </label>
                            <input type="number" step="0.001"  maxlength="10" class="form-control" name="ta_cost"
                                placeholder=" TA Cost " value="{{$instanceEstimate->ta_cost}}" />
                            @else
                            <label class="card-title"> TA Cost </label> <br />
                            {{$instanceEstimate->ta_cost}}
                            <input type="hidden" name="tsc_cost" value="{{$instanceEstimate->ta_cost}}" />
                            @endif
                        </div>
                    </div>

                </div>
                <br />
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="card-title required"> Land Availability </label>
                            <textarea rows="3" type="text" class="form-control" rows="2" id="land_availabilty"
                                name="land_availabilty"
                                placeholder="land_availabilty">{{$instanceEstimate->land_availabilty}} </textarea>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="card-title required"> Land Type </label>
                            <textarea rows="3" type="text" class="form-control" rows="2" id="land_type" name="land_type"
                                placeholder="land_type">{{$instanceEstimate->land_type}} </textarea>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="card-title required"> Land Area in sqm mtr </label>
                            <input type="number" step="0.001" maxlength="10" class="form-control" name="land_area" id="land_area"
                                placeholder=" Land Area " value="{{$instanceEstimate->land_area}}" />
                        </div>
                    </div>

                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="card-title"> Provisions </label>
                            <textarea rows="3" type="text" class="form-control ckeditor" rows="2" id="provisions"
                                name="provisions" placeholder="provisions">{{$instanceEstimate->provisions}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="card-title required"> Urban </label>
                            <select class="form-select " name="urban" id="urban">
                                <option value="1" {{$instanceEstimate->urban == 1 ? 'Selected' : ''}}> Yes</option>
                                <option value="0" {{$instanceEstimate->urban == 0 ? 'Selected' : ''}}> No</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="card-title required"> EFC Date </label>
                            <input type="date" class="form-control" name="efc_date" id="efc_date"
                                placeholder="Effective Date" value="{{$instanceEstimate->efc_date }}" />
                        </div>
                    </div>

                </div>
                <br />
                <div class="row">
                    <div class="col-md-4 ">
                        <div class="form-group">
                            <button id="btnAddRegDetails" type="submit" class="btn btn-info">
                                Update Estimate Details </button>
                            <br />
                            <input type="hidden" name="instance_id" value="{{ $instance->id }}" />
                            <input type="hidden" name="instance_Estimate_id" value="{{ $instance->estimate->id }}" />
                        </div>
                    </div>
                </div>
                <br />
            </form>
        </div>
    </div>
</div>

@endsection

@section('footscripts')
@endsection
