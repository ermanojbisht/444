@extends('layouts.type200.main')


@section('headscripts')

<!-- Select2 CSS -->
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .select2-selection__rendered {
        line-height: 18px !important;
    }

</style>
@endsection --}}

@section('sidebarmenu')
    @include('layouts.type200._commonpartials._sidebarmenu',['instance_estimate_id'=>$instanceEstimate->id??0, 'instance_id'=>$instanceEstimate->instance_id])
@endsection

@section('pagetitle')
     Update Status
@endsection

@section('breadcrumbNevigationButton')
    @include('layouts._commonpartials._breadcrumbNavbar',
                ['instance_estimate_id'=>$instanceEstimate->id??0,'instance_id'=>$instanceEstimate->instance_id])
@endsection

@section('breadcrumb')
    @include('layouts._commonpartials._breadcrumb',
        ['datas'=> [
            ['label'=>'Estimate','active'=>false],
            ['label'=>'Estimate ID - '.$instance->id,'active'=>false],
            ['label'=>'Update Status ','active'=>true],
                    ]  
        ])
@endsection


@section('content')
@include("track.estimate.partial._EstimateInfo",[
                        'instance' => $instance,
                        'addDetails' => true,
                        'instanceEstimate' => $instanceEstimate,
                        'blocks' => $instance_blocks,
                        'Constituencies' => $instance_constituencies
                        ])
<div class="container-fluid">
    <div class="card callout callout-info">
        <div class="card-body ">
            <form action="{{ route('updateEstimateStatus') }}" method="POST">
                @csrf
                <input type="hidden" name="instance_id" value="{{ $instance->id }}">
                <div class="row">
                    <div class="col-auto" style="text-align:right"> Status :</div>
                    <div class="col-auto">
                        <select id="status_master_id" name="status_master_id" tabindex="3"
                            aria-hidden="true" class="form-select">
                            @foreach($statusses as $status)
                            <option {{ ($instance->status_master_id == $status->id) ?
                                "selected" : "" }}
                                value="{{ $status->id }}"> {{$status->name}} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-info"> Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
