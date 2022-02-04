@extends('layouts.type200.pdf')
@section('styles')
@endsection

@section('content')

<div class="page">
    <div style="margin-bottom: 0.7cm; margin-top: 0.7cm">
        <h1>Performance Report</h1>
    </div>
   <h2>{{$acr->employee->name}}</h2>
   <h2>Period:{{$acr->from_date->format('d M Y')}} to {{$acr->to_date->format('d M Y')}}</h2>
</div>
@endsection
