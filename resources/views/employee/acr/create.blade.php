@extends('layouts.type200.main')

@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
@endsection
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu',['active'=>'arc'])
@endsection

@section('pagetitle')
My ACR
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
['label'=> 'Acr ','active'=>false],
['label'=> 'Create','active'=>true]
]])
@endsection

@section('content')

{{-- {{$acr->id}} --}}

{{-- @foreach($groupIds as $groupId)
{{$groupId}}
<br>
{{config('acr.group')[$groupId]['head']}}
<br>
{{config('acr.group')[$groupId]['head_note']}}
<br>
@foreach($datas as $data)

{{$data->description}}
<br>
@endforeach
{{config('acr.group')[$groupId]['foot_note']}}
<br>
@endforeach --}}
@endsection