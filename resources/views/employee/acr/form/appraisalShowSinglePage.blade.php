@extends('layouts.type200.pdf')

@section('content')

<div class="card">
	<div class="card-header">
		<p class="card-title fw-semibold h5">Part -III Appraisal</p> 
	</div>
	@if($acr->report_on)
		<div class="card-body">
			<p class="fw-semibold">
				प्रतिवेदक अधिकारी की टिप्पणी 
			</p>
			<p class="text-info">{{$acr->appraisal_note_1??'--'}}</p>
			<p class="fw-bold h5">
		  		प्रतिवेदक अधिकारी द्वारा दिए गए अंक - {{$acr->report_no??' --??-- '}}
			</p>
			<div>
				<p> प्रतिवेदक : {{$acr->reportUser()->name}} </p>
				<p> on : {{$acr->report_on->format('d M Y')}}</p>

			</div>
		</div>
	@endif
	@if($acr->review_on)
		<div class="card-body">
			<p class="fw-semibold">
				समीक्षक अधिकारी की टिप्पणी 
			</p>
			<p class="text-info">{{$acr->review_remark??'--'}}</p>

			<p class="fw-bold h5">
		  		समीक्षक अधिकारी द्वारा दिए गए अंक - {{$acr->review_no??' --??-- '}}
			</p>
			<div>
				<p> समीक्षक : {{$acr->reviewUser()->name}} </p>
				<p> on : {{$acr->report_on->format('d M Y')}}</p>

			</div>
		</div>
	@endif

	@if($acr->accept_no)
		<div class="card-body">
			<p class="fw-semibold">
				स्वीकर्ता अधिकारी की टिप्पणी 
			</p>
			<p class="text-info">{{$acr->accept_remark??'--'}}</p>

			<p class="fw-bold h5">
		  		स्वीकर्ता अधिकारी द्वारा दिए गए अंक - {{$acr->accept_no??' --??-- '}}
			</p>
			<div>
				<p> स्वीकर्ता : {{$acr->acceptUser()->name}} </p>
				<p> on : {{$acr->report_on->format('d M Y')}}</p>

			</div>
		</div>
	@endif

</div>
@endsection
