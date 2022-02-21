@extends('layouts.type200.pdf')

@section('content')

<div class="card">
	<div class="card-header">
		<p class="card-title fw-semibold h5">Part -III Appraisal</p> 
	</div>
	@if($acr->report_on)
		<div class="card-body">
			<p class="fw-semibold h5">
				प्रतिवेदक अधिकारी की अभियुक्ति 
				 <span class="small text-muted">
				 	संबंधित क्रमचारी के व्यक्तित्व तथा कार्य के मूल्याकन हेतु मुख्यत: निम्नलिखित विशिष्ट पहलुओ की पृष्टभूमि मे वर्णात्मक शैली मे प्रतिवेदक अधिकारी द्वारा लिखी जाएगी 
				 	<li>(क) अभिव्यक्त करें की योग्यता</li>
				 	<li>(ख) सहयोगियों से संबंध</li>
				 	<li>(ग) बौद्धिक स्तर</li>
				 	<li>(घ) श्रमशीलता एवं जागरूकता</li>
				 	<li>(ड़) कर्तव्य निर्वहन के प्रति लग्न</li>
				 	<li>(च) अन्य टिप्पणी</li>
				 </span>
			</p>
			<p class="text-info border border-primary p-3" style="min-height: 150px;">
				{{$acr->appraisal_note_1??'--'}}
			</p>
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
				समीक्षक अधिकारी की अभियुक्ति 
			</p>
			<p class="text-info border border-primary p-3" style="min-height: 150px;">
				{{$acr->review_remark??'--'}}
			</p>

			<p class="fw-bold h5">
		  		समीक्षक अधिकारी द्वारा दिए गए अंक - {{$acr->review_no??' --??-- '}}
			</p>
			<div>
				<p> समीक्षक : {{$acr->reviewUser()->name}} </p>
				<p> on : {{$acr->report_on->format('d M Y')}}</p>

			</div>
		</div>
	@endif
	@if(!$acr->isTwoStep)
		@if($acr->accept_no)
			<div class="card-body">
				<p class="fw-semibold">
					स्वीकर्ता अधिकारी की टिप्पणी 
				</p>
				<p class="text-info border border-primary p-3" style="min-height: 150px;">
					{{$acr->accept_remark??'--'}}
				</p>

				<p class="fw-bold h5">
			  		स्वीकर्ता अधिकारी द्वारा दिए गए अंक - {{$acr->accept_no??' --??-- '}}
				</p>
				<div>
					<p> स्वीकर्ता : {{$acr->acceptUser()->name}} </p>
					<p> on : {{$acr->report_on->format('d M Y')}}</p>

				</div>
			</div>
		@endif
	@endif

</div>
@endsection
