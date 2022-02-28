@extends('layouts.type200.main')

@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection

@section('pagetitle')
<small> Alter ACR after successful process</small>
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],

['label'=> 'Edit ACR after successful representation','active'=>true]
]])
@endsection

@section('content')
{{Auth::user()->name}} owns the responsiblity of correctness of data filled in this form.
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <p class="fw-bold"> Details of ACR :- </p>
            </div>
            <div class="col-md-6">
                <p class="fw-semibold  text-info"> Name:{{$acr->employee->shriName }} </p>
                <p class="fw-semibold"> Period Of Appraisal : {{$acr->from_date->format('Y-m-d') }} to {{$acr->to_date->format('Y-m-d') }}
                </p>
            </div>
        </div>

        <form class="form-horizontal" method="POST" action="{{route('acr.uupdate.alteredAcr',['acr'=>$acr])}}">
            @csrf
            <input type="hidden" name="acr_id" value="{{$acr->id}}" />
            <input type="hidden" name="old_accept_no" value="{{$acr->accept_no}}" />
            <div class="row">
                <div class="col-md-12 form-group">
                    <label>Order detail and decision detail after successful representation </label>
                    <textarea type="text" class="form-control {{ $errors->has('final_accept_remark') ? 'is-invalid' : '' }}" name="final_accept_remark"> {{old('final_accept_remark') ?? '' }}</textarea>
                    @if($errors->has('final_accept_remark'))
                    <div class="invalid-feedback">
                        {{ $errors->first('final_accept_remark') }}
                    </div>
                @endif
                <span class="help-block"></span>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label>Rectified No </label>
                    <input type="number" step=".01" class="form-control {{ $errors->has('accept_no') ? 'is-invalid' : '' }}" name="accept_no" value="{{old('accept_no') ?? '' }}" >
                    @if($errors->has('accept_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('accept_no') }}
                    </div>
                @endif
                <span class="help-block">Orignal Accept no is {{$acr->accept_no}} </span>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <input type="submit" class="btn btn-primary " value="Update ACR" />
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
