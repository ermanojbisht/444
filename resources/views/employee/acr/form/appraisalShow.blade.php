@extends('layouts.type200.pdf')

@section('content')
@php $view= true; @endphp 
<div class="card">
	<div class="card-header">
		<p class="card-title fw-semibold h5">Part -III Appraisal</p> 
	</div>
	<div class="card-body">
		<p class="fw-semibold">
			1. Please state whether you agree with the responses relating to the accomplishments of the work plan and
			unforeseen tasks as filled out in Section II. If not please furnish factual details.
		</p>
		<p class="text-info border border-primary p-3" style="min-height: 150px;">{{$acr->appraisal_note_1??'--'}}</p>
		<p class="fw-semibold">
			2. Please comment on the claim(if made) of exceptional contribution by the officer reoorted upon.
		</p>
		<p class="text-info border border-primary p-3" style="min-height: 150px;">{{$acr->appraisal_note_2??'--'}}</p>
		<p class="fw-semibold">
			3. Has the officer reported upon met with any significant failures in respect of his work? If yes, Please
			furnish factual details.
		</p>
		<p class="text-info border border-primary p-3" style="min-height: 150px;">{{$acr->appraisal_note_3??'--'}}</p>
	</div>
	<div class="card-body">
			@php $total_marksA = $reporting_marksA = $reviewing_marksA = 0; @endphp
			<table class="table table-bordered table-sm">
				<thead class="">
					<tr class="text-center align-middle">
						<th rowspan="2">#</th>
						<th rowspan="2">Parameter</th>
						<th rowspan="2">Max Marks</th>
						<th colspan="2">Marks awarded by</th>
					</tr>
					<tr class="text-center align-middle ">
						<th>Reporting Authority</th>
						<th>Reviewing Authority</th>
					</tr>
				</thead>
				<tbody>
					<tr class="fw-semibold fs-5">
						<td colspan="5">4-A - Assessment of Performance</td>
					</tr>
					@foreach($requiredParameters as $required_parameter)
					@php
					if($required_parameter->applicable == 1){
						$total_marksA = $total_marksA + $required_parameter->max_marks;
						$classtext = "";
						$not_applicable = "";
						$reporting_marksA = $reporting_marksA + $required_parameter->reporting_marks??0;
						$reviewing_marksA = $reviewing_marksA + $required_parameter->reviewing_marks??0;
						
					}else{
						$classtext = "text-decoration-line-through";
						$not_applicable = "<small>Not Applicable</small>";
					}
					@endphp
					<tr class="text-center">
						<td>{{$loop->iteration}}</td>
						<td class="{{$classtext??''}} text-start"> {{$required_parameter->description}} </td>
						<td class="{{$classtext??''}}"> {{$required_parameter->max_marks}} </td>
						<td>
							@if($applicableParameters != 0)
								{{$required_parameter->reporting_marks??''}}
							@endif 
							{!!$not_applicable!!} 
						</td>
						<td> @if($applicableParameters != 0)
								{{$required_parameter->reviewing_marks??''}}
							@endif 
							{!!$not_applicable!!} </td>
					</tr>
					@endforeach
					@php
					if($total_marksA>0){
						$net_reporting_marksA = round(80*$reporting_marksA/$total_marksA,2);
						$net_reviewing_marksA = round(80*$reviewing_marksA/$total_marksA,2);
					}else{
						$net_reporting_marksA = 0;
						$net_reviewing_marksA = 0;
					}
					@endphp
					@if($applicableParameters == 0)
						<tr class="bg-danger fw-bold" id="exceptional_row">
							<td></td>
							<td class="text-end">Due to User Declare all Parameters as not Applicable hence Number Given here </td>
							<td class="text-center">80</td>
							<td class="text-center">{{$exceptional_reporting_marks}}</td>
							<td class="text-center">{{$exceptional_reviewing_marks}}</td>
						</tr>
					@else
						<tr class="fw-semibold text-center">
							<td></td>
							<td class="text-end">Sum for 4- A</td>
							<td>{{$total_marksA}}</td>
							<td>
								{{$reporting_marksA??''}}
							</td>
							<td>{{$reviewing_marksA??''}}</td>
						</tr>
						<tr class="bg-light fw-semibold text-center">
							<td></td>
							<td class="text-end">Say</td>
							<td>80</td>
							<td> {{$net_reporting_marksA}} </td>
							<td> {{$net_reviewing_marksA}} </td>
						</tr>
					@endif
					<tr class="fw-semibold fs-5">
						<td colspan="5">4-B - Assessment of Personal Attributes</td>
					</tr>
					@php
						$total_marksB = 0;
						$reporting_marksB = 0;
						$reviewing_marksB = 0;
					@endphp
					@foreach($personal_attributes as $personal_attribute)
					@php
						$total_marksB = $total_marksB + $personal_attribute->max_marks;
						$reporting_marksB = $reporting_marksB + $personal_attribute->reporting_marks??0;
						$reviewing_marksB = $reviewing_marksB + $personal_attribute->reviewing_marks??0;
					@endphp
					<tr class="text-center">
						<td> {{$loop->iteration}}</td>
						<td class="text-start">{{$personal_attribute->description}}</td>
						<td> {{$personal_attribute->max_marks}}</td>
						<td> {{$personal_attribute->reporting_marks??'0'}} </td>
						<td> {{$personal_attribute->reviewing_marks??'0'}} </td>
					</tr>
					@endforeach
					<tr class="text-center bg-light fw-semibold">
						<td></td>
						<td class="text-end">Sum for 4- B</td>
						<td >{{$total_marksB}}</td>
						<td >{{$reporting_marksB??0}}</td>
						<td >{{$reviewing_marksB??0}}</td>
					</tr>
					<tr class="fw-semibold fs-5">
						<td colspan="5">4-C - Deductions</td>
					</tr>
					@php
						$total_marksC = $reporting_marksC = $reviewing_marksC = 0;
					@endphp
					@foreach($requiredNegativeParameters as $requiredNegativeParameter)
						@php
							$total_marksC = $total_marksC + $requiredNegativeParameter->max_marks;
							$reporting_marksC = $reporting_marksC + $requiredNegativeParameter->reporting_marks??0;
							$reviewing_marksC = $reviewing_marksC + $requiredNegativeParameter->reviewing_marks??0;
						@endphp
					<tr class="text-center">
						<td>{{$loop->iteration}}</td>
						<td class="text-start">{{$requiredNegativeParameter->description}}</td>
						<td> {{$requiredNegativeParameter->max_marks}}</td>
						<td> {{$requiredNegativeParameter->reporting_marks??'0'}}</td>
						<td> {{$requiredNegativeParameter->reviewing_marks??'0'}}</td>
					</tr>
					@endforeach
					<tr class="bg-light fw-semibold text-center">
						<td></td>
						<td class="text-end">Sum for 4- C</td>
						<td >{{$total_marksC}}</td>
						<td >{{$reporting_marksC??0}}</td>
						<td >{{$reviewing_marksC??0}}</td>
					</tr>
				</tbody>
			</table>
	</div>
	<div class="card-body">
		<p class="fw-semibold h5">5. Summary of Marks awarded</p>
		<table class="table table-bordered table-sm">
			<thead>
				<tr class="text-center align-middle fw-semibold">
					<th>Description</th>
					<th class="text-center">Max. Marks</th>
					<th class="text-center">Marks awarded by <br> Reporting Authority</th>
					<th class="text-center">Marks awarded by <br> Reviewing Authority</th>
				</tr>
			</thead>
			<tbody>
				<tr class="text-center">
					<td class="text-start">Assessment of work</td>
					<td>80</td>
					<td>
						@if($applicableParameters == 0)
							{{$exceptional_reporting_marks??''}}
						@else
							{{$net_reporting_marksA}}
						@endif
					</td>
					<td>
						@if($applicableParameters == 0)
							{{$exceptional_reviewing_marks??''}}
						@else
							{{$net_reviewing_marksA}}
						@endif
					</td>
				</tr>
				<tr class="text-center">
					<td class="text-start">Assessment of personal attributes</td>
					<td >{{$total_marksB}}</td>
					<td >{{$reporting_marksB}}</td>
					<td >{{$reviewing_marksB??'0'}}</td>
				</tr>
				<tr class="text-center">
					<td class="text-start">Deduction (max {{$total_marksC}})</td>
					<td></td>
					<td>{{$reporting_marksC??'0'}}</td>
					<td>{{$reviewing_marksC??'0'}}</td>
				</tr>
				<tr class="bg-light fw-bold fs-5 text-center">
					<td class="text-end">Net</td>
					<td class="text-center">{{80 + $total_marksB}}</td>
					<td class="text-center">{{$acr->report_no??'not finalized yet'}}</td>
					<td class="text-center">{{$acr->review_no??'not finalized yet'}}</td>
				</tr>
			</tbody>

		</table>
		<p>Reference Table for Grading :</p>
		<table class="table table-bordered table-sm">
			<tr class="text-center">
				<td>Grading</td>
				<td>Outstanding</td>
				<td>Very Good</td>
				<td>Good</td>
				<td>Satisfactory</td>
				<td>Unsatisfactory</td>
			</tr>
			<tr class="text-center">
				<td>Marks</td>
				<td>>80</td>
				<td>>60 upto 80</td>
				<td>>40 upto 60</td>
				<td>>20 upto 40</td>
				<td>upto 20 </td>
			</tr>
		</table>
	</div>
	<div class="d-flex justify-content-around">
		@if($acr->report_on)
		<div>
			<p> Repored By : {{$acr->reportUser()->shriName}} </p>
			<p> on : {{$acr->report_on->format('d M Y')}}</p>

		</div>
		@endif
		@if($acr->review_on)
		<div>
			<p> Reviewed By : {{  $acr->reviewUser()->shriName }} </p>
			<p> On : {{($acr->review_on)?$acr->review_on->format('d M Y'),''}}</p>
			
		</div>
		@endif
		
	</div>
</div>
@endsection
