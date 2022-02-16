@extends('layouts.type200.pdf')

@section('content')

<div class="card">
	<div class="card-header">
		<p class="card-title fw-semibold h5">Part -III Appraisal</p> 
	</div>
	@if($acr->report_on)
		<div class="card-body">
			<p class="fw-semibold">
				रिपोर्टिंग अधिकारी की टिप्पणी 
			</p>
			<p class="text-info">{{$acr->appraisal_note_1??'--'}}</p>
			<p class="fw-bold h5">
		  		रिपोर्टिंग अधिकारी द्वारा दिए गए अंक - {{$acr->report_no??' --??-- '}}
			</p>
			<div>
				<p> Repored By : {{$acr->reportUser()->name}} </p>
				<p> on : {{$acr->report_on->format('d M Y')}}</p>

			</div>
		</div>
	@endif
	@if($acr->review_on)
		<div class="card-body">
			<p class="fw-semibold">
				Reviewing अधिकारी की टिप्पणी 
			</p>
			<p class="text-info">{{$acr->review_remark??'--'}}</p>

			<p class="fw-bold h5">
		  		Reviewing अधिकारी द्वारा दिए गए अंक - {{$acr->review_no??' --??-- '}}
			</p>
			<div>
				<p> Reviewed By : {{$acr->reviewUser()->name}} </p>
				<p> on : {{$acr->report_on->format('d M Y')}}</p>

			</div>
		</div>
	@endif

</div>
@endsection
