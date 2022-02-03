@extends('layouts.type200.pdf')
@section('styles')
@endsection

@section('content')

<div class="page">
   <h1>Performance Report</h1>
   <h2>{{$acr->employee->name}}</h2>
   <h2>Period:{{$acr->from_date->format('d M Y')}} to {{$acr->to_date->format('d M Y')}}</h2>
</div>
Hello Dear
@endsection
