@extends('layouts.type200.main')

@section('sidebarmenu')
    {{-- @include('layouts.type200._commonpartials._sidebarmenu',['instance_estimate_id'=>$instanceEstimate->id??0]) --}}
@endsection

@section('pagetitle')
     Add/ Edit Sub-Works/ Group <small>(example: one group for each road/ Bridge )</small>
@endsection

@section('breadcrumbNevigationButton')
    @include('layouts._commonpartials._breadcrumbNavbar',
                ['instance_estimate_id'=>$instanceEstimate->id??0,'instance_id'=>$instanceEstimate->instance_id])
@endsection

@section('breadcrumb')
    @include('layouts._commonpartials._breadcrumb',
        [   'datas'=> [
                        ['label'=>'Estimate','active'=>false],
                        ['label'=>'Estimate ID- '.$instanceEstimate->id,'active'=>false],
                        ['label'=>'Estimate Sub Group List','active'=>true],
                    ]  
        ])
@endsection

@section('content')
<div class="container-fluid">
<x-track.instance-estimate-header :instanceEstimate="$instanceEstimate" pagetitle="Estimate Sub Group List (example: one group for each road )"
                                      toBackroutename="instanceEstimate.instanceEstimateFeature.index"
                                      :routeParameter="[$instanceEstimate->id]"
                                      routelabel="Back to Estimate Feature list"/>
<div class="card callout callout-info">
    <form action="{{ route('instanceEstimate.group.store',$instanceEstimate->id) }}" method="post" enctype="multipart/form-data" class="">
        <div class="row align-items-center p-3">
            {{ csrf_field() }}
            <div class="col-md-auto">
                <label for="inputPassword6" class="h5 fw-bold">Add Sub-Work</label>
                <span class="help-block text-success pull-right">
                    <small>* name should be short </small>
                </span>
            </div>
            <div class="form-group col-md-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                <input type="text" name="name" id="inputPassword6" class="form-control" >{{ old('name') }}</input>
                @if ($errors->has('name'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-md-auto">
                <button type="submit" name="saveBtn" class="btn btn-flat btn-primary pull-right">Save</button>
            </div>
        </div>
    </form>
</div>
<div class="card">
    <p class="fs-4 fw-semibold ps-3" >List of Sub-Works/ Groups Under This Estimate</p>
    <table class="table">
        <thead class="table-info">
            <tr class="fw-bold fs-5">
                <th style="width:auto;">#.</th>
                <th style="width:auto;">ID</th>
                <th style="width:60%;">name</th>
                <th style="width:auto;"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($estimateGroups as $group)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{ $group->id }}</td>
                    <td>{{ $group->name }}</td>
                    <td>
                        <div class="row justify-content-end">
                            <div class="col-auto">
                                <a class="btn btn-outline-info" href="{{ route('instanceEstimate.group.edit', [$group->instance_estimate_id, $group->id]) }}">
                                    <svg style="width: 24px; height: 24px;">
                                        <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-pen-alt')}}"></use>
                                    </svg>
                                    Edit
                                </a> 
                            </div>
                            <div class="col-auto">
                                    <form action="{{ route('instanceEstimate.group.destroy', ['instanceEstimate'=>$group->instance_estimate_id, 'group'=>$group->id]) }}" method="POST">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" name="saveBtn" class="btn btn-outline-danger">
                                            <svg style="width: 24px; height: 24px;">
                                                <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-trash')}}"></use>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="fw-semibold text-center">No Sub-Work/ Group.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
</div>

</div>
@endsection
