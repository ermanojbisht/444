@extends('layouts.type200.main')

@section('sidebarmenu')
   {{--  @include('layouts.type200._commonpartials._sidebarmenu',['instance_estimate_id'=>$instanceEstimate->id??0]) --}}
@endsection

@section('pagetitle')
     Estimate Feature and Provision List
@endsection

@section('breadcrumbNevigationButton')
    @include('layouts._commonpartials._breadcrumbNavbar',
                ['instance_estimate_id'=>$instanceEstimate->id??0,'instance_id'=>$instanceEstimate->instance_id]) {{--  --}}
@endsection

@section('breadcrumb')
    @include('layouts._commonpartials._breadcrumb',
        [   'datas'=> [
                        ['label'=>'Estimate','active'=>false],
                        ['label'=>'Estimate ID- '.$instanceEstimate->id,'active'=>false],
                        ['label'=>'Estimate Feature and Provision List','active'=>true],
                    ]  
        ])
@endsection

@section('content')
<div class="container-fluid">
<x-track.instance-estimate-header :instanceEstimate="$instanceEstimate" pagetitle="Estimate Feature/provision List"
                                      toBackroutename="track.estimate.view"
                                      :routeParameter="['instance_estimate'=>$instanceEstimate->id]"
                                      routelabel="Back to Estimate Tracking Details"/>
<div class="card "> {{-- callout callout-info --}}

</div>
    <a class="btn btn-group-sm btn-info"
       href="{{ route("instanceEstimate.instanceEstimateFeature.create", $instanceEstimate->id) }}">Add estimate
        Feature</a>
    <table class="table datatable table-bordered table-striped table-hover" id="progresstbl">
        <thead>
        <tr>
            <th>#.</th>
            <th>ID</th>
            <th>Item</th>
            <th>Sub Group</th>
            <th>rate in lakhs</th>
            <th>qty</th>
            <th>cost in lakhs</th>
            <th>remark</th>
            {{-- @can('edit-estimate-feature') --}}
            <th></th>
            {{-- @endcan --}}
        </tr>
        </thead>
        <tbody>
        @php $sno = 0 @endphp
        @forelse($estimateFeatures as $feature)
            <tr>
                <td>{{ ++$sno }}</td>
                <td>{{ $feature->id }}</td>
                <td>
                    @if($feature->type)
                    {{ $feature->type->name }}
                    @else
                    none
                    @endif
                </td>
                <td>
                    @if($feature->estimateGroup)
                    {{$feature->estimateGroup->name}}
                    @else
                    none
                    @endif
               </td>
                <td>{{ $feature->rate }}</td>
                <td>{{ $feature->qty}}</td>
                <td>{{ $feature->cost }}</td>
                <td>{{ $feature->remark }}</td>
                {{-- @can('edit-estimate-feature') --}}
                <td>
                    <a href="{{ route('instanceEstimate.instanceEstimateFeature.edit', [$instanceEstimate->id, $feature->id]) }}"<i class="fa fa-pencil">edit</i></a>

                    <form
                        action="{{ route('instanceEstimate.instanceEstimateFeature.destroy', ['instanceEstimate'=>$feature->instance_estimate_id, 'instanceEstimateFeature'=>$feature->id]) }}"
                        method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                    </form>
                    {{-- @endcan --}}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No Feature found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
