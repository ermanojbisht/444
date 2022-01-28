{{-- @extends('layouts.type100.main') --}}
@extends('layouts.type200.main')

@section('sidebarmenu')
    @include('layouts.type200._commonpartials._sidebarmenu',['instance_estimate_id'=>$instanceEstimate->id??0])
@endsection

@section('content')

<div class="container-fluid">
<x-track.instance-estimate-header :instanceEstimate="$instanceEstimate" pagetitle="Add Estimate sub group"
                                      toBackroutename="instanceEstimate.group.index"
                                      :routeParameter="['instanceEstimate'=>$instanceEstimate->id]"
                                      routelabel="Back to Estimate Group list"/>

    <div class="col-sm-12">
    <div class="card">
        <div class="card-header"></div>
        <div class="card-body card-block">
            {{-- form --}}
            <form action="{{ route('instanceEstimate.group.store',$instanceEstimate->id) }}" method="post" enctype="multipart/form-data" class="">
                {{ csrf_field() }}
                <div class="row">

                    {{-- name --}}
                    <div class="form-group col-md-12 {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="">name</label>
                        <span class="help-block text-success pull-right">
                            <small>* name should be short </small>
                        </span>
                        <textarea type="text" name="name" class="form-control" >{{ old('name') }}</textarea>
                        @if ($errors->has('name'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
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

@endsection
