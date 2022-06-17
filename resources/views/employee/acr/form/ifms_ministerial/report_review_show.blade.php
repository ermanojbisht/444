@extends('layouts.type200.pdf')

@section('content')

<div class="card">
	<div class="card-header">
		<p class="card-title fw-semibold h5">Part -III Appraisal</p> 
	</div>
	@if($acr->report_on)
		<div class="card-body">
			<p class="text-center fw-semibold h5">Part -III Appraisal</p>
			<p class="text-center fw-semibold ">प्रतिवेदक अधिकारी की अभ्युक्ति</p>
			<p class="fw-semibold ">1- व्यक्तिगत गुणों का मूल्यांकन</p>
				<table class="table table-sm">
					<thead>
						<tr>
							<th class="text-info">#</th>
							<th class="text-info">व्यक्तिगत गुण</th>
							<th class="text-info">अधिकतम अंक</th>
							<th class="text-info">अंक</th>
							<th class="text-info">टिप्पणी</th>
						</tr>	
					</thead>
					<tbody>
						@foreach($acr->acrMasterParameters->where('config_group',4001) as $parameter)
						<tr>
							<td class="text-info">{{$loop->index + 1}}</td>
							<td class="text-info">{{$parameter->description}}</td>
							<td class="text-info">{{$parameter->max_marks}}</td>
							@if($acr->filledparameters->where('acr_master_parameter_id',$parameter->id)->count() > 0)
								<td class="text-info">
									{{$acr->filledparameters->where('acr_master_parameter_id',$parameter->id)->first()->reporting_marks}}
								</td>
								<td class="text-info">
									{{$acr->filledparameters->where('acr_master_parameter_id',$parameter->id)->first()->status}}
								</td>
							@else
								<td>--</td>
								<td>--</td>
							@endif
						</tr>
						@endforeach
					</tbody>
				</table>
				<br>
				<p class="fw-semibold mt-0">2- किए गए कार्यों का मूल्यांकन</p>
				<table class="table table-sm">
					<thead>
						<tr>
							<th class="text-info">#</th>
							<th class="text-info">मदें</th>
							<th class="text-info">अधिकतम अंक</th>
							<th class="text-info">अंक</th>
							<th class="text-info">टिप्पणी</th>
						</tr>	
					</thead>
					<tbody>
						@foreach($acr->acrMasterParameters->where('config_group',4002) as $parameter)
						<tr>
							<td class="text-info">{{$loop->index + 1}}</td>
							<td class="text-info">{{$parameter->description}}</td>
							<td class="text-info">{{$parameter->max_marks}}</td>
							@if($acr->filledparameters->where('acr_master_parameter_id',$parameter->id)->count() > 0)
								<td class="text-info">
									{{$acr->filledparameters->where('acr_master_parameter_id',$parameter->id)->first()->reporting_marks}}
								</td>
								<td class="text-info">
									{{$acr->filledparameters->where('acr_master_parameter_id',$parameter->id)->first()->status}}
								</td>
							@else
								<td>--</td>
								<td>--</td>
							@endif
						</tr>
						@endforeach
					</tbody>
				</table>
				<p class="fw-semibold ">3- प्रतिवेदक अधिकारी की टिप्पणी <small>(अधिकतम 100 शब्द)</small></p>
				<p class="border border-info p-2 m-2">{{$acr->appraisal_note_1??'----'}}</p>

				<p class="fw-semibold ">4- समग्र ग्रेड <span class="fw-semibold text-info h4">{{$acr->report_no}}</span></p>

				<p class="fw-semibold text-end m-0">by  <span>{{$acr->userOnBasisOfDuty('report')->name}}</span></p>
				<p class="fw-semibold text-end m-0">on <span>{{$acr->report_on->format('d m Y')}}</span></p>
				<hr>
		</div>
	@endif
	
		@if($acr->review_on)
			<div class="card-body">
					<p class="text-center fw-semibold h5">
						Part -IV {{$acr->isTwoStep?'Accept':'Review'}}
					</p>
					<p class="text-center fw-semibold ">
						{{$acr->isTwoStep?'स्वीकर्ता':'समीक्षक'}}
						अधिकारी की अभ्युक्ति
					</p>
					<P>क्या आप प्रतिवेदक अधिकारी द्वारा किए गए मूल्यांकन से सहमत है? मत भिन्नता की स्थिति मे कारण तथा टिप्पणी भी अंकित करें</P>
						<p>{{$acr->review_remark}}</p>
						<div class="row g-3 align-items-center mt-3">
						  <div class="col-auto">
						    <span>समग्र ग्रेड</span>
						  </div>
						  <div class="col-auto">
						  	<span class="fw-bold h4">{{$acr->review_no}}</span>
						  </div>
						</div>
						<div>
							<br>
							<br>
							<br>
							<br>
						<p>  {{$acr->reviewUser()->shriName}} </p>
						<p> on : {{$acr->review_on->format('d M Y')}}</p>

					</div>
					<hr>
			</div>
		@endif
	

{{-- 	@if(!$acr->isTwoStep)
		@if($acr->accept_no)
			<div class="card-body">
				<p class="text-center fw-semibold h5">
					स्वीकर्ता अधिकारी की टिप्पणी 
				</p>
				<p class="text-info border border-primary p-3" style="min-height: 150px;">
					{{$acr->accept_remark??'--'}}
				</p>

				<p class="fw-bold h5">
			  		स्वीकर्ता अधिकारी द्वारा दिए गए अंक - {{$acr->accept_no??' --??-- '}}
				</p>
				<div>
					<p> स्वीकर्ता : {{$acr->acceptUser()->shriName}} </p>
					<p> on : {{$acr->accept_on->format('d M Y')}}</p>

				</div>
			</div>
		@endif
	@endif --}}

</div>
@endsection
