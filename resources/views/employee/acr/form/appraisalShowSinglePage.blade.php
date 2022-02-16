@extends('layouts.type200.pdf')

@section('content')
@php $view= true; @endphp 
<div class="card">
	<div class="card-header">
		<p class="card-title fw-semibold h5">Part -III Appraisal</p> 
	</div>
	<div class="card-body">
		<p class="fw-semibold">
			1. Please state the responses relating to the accomplishments .
		</p>
		<p class="text-info">{{$acr->appraisal_note_1??'--'}}</p>
	</div>


	<div class="d-flex justify-content-around">
		@if($acr->report_on)
		<div>
			<p> Repored By : {{$acr->reportUser()->name}} </p>
			<p> on : {{$acr->report_on->format('d M Y')}}</p>

		</div>
		@endif
		@if($acr->review_no)
		<div>
			<p> Reviewed By : {{  $acr->reviewUser()->name }} </p>
			<p> On : {{$acr->review_on->format('d M Y')}}</p>
			
		</div>
		@endif
		
	</div>
</div>
@endsection
