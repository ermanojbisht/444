@extends('layouts.type200.main')
@section('sidebarmenu')
	@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection
@section('pagetitle')
	Part -III Appraisal <small>(By Reviewing Officer)</small>
@endsection
@section('content')
	{{-- to be shifted in main style  --}}
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
  
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
	<div class="card">
		<div class="card-body border border-2 border-info">
			<p class="fw-semibold h4">Reporting Officers Remarks :</p>
			<p class="fw-semibold h5 text-muted">
			  	1. Please state whether you agree with the responses relating to the accomplishments of the work plan and unforeseen tasks as filled out in Section II. If not please furnish factual details.
			</p>
			<p class="text-info">{{$acr->appraisal_note_1??'--'}}</p>
		  	<p class="fw-semibold h5 text-muted">
		  		2. Please comment on the claim(if made) of exceptional contribution by the officer reoorted upon.
		  	</p>
			<p class="text-info">{{$acr->appraisal_note_1??'--'}}</p>
		  	<p class="fw-semibold h5 text-muted">
		  		3. Has the officer reported upon met with any significant failures in respect of his work? If yes, Please furnish factual details.
		  	</p>
			<p class="text-info">{{$acr->appraisal_note_1??'--'}}</p>
		</div>
		<form class="form-horizontal" method="POST" action="{{route('acr.form.storeAppraisal2')}}">
			@csrf
			<input type="hidden" name="acr_id" value='{{$acr->id}}'>
			
			<div class="card-body border border-2 border-success">
				<div class="form-group">
					@php $total_marksA = $reporting_marksA = $reviewing_marksA = 0; @endphp
					<table class="table table-bordered table-sm">
						<thead class="bg-info ">
							<tr class="text-center align-middle ">
								<th rowspan="2">#</th>
								<th rowspan="2">Parameter</th>
								<th rowspan="2">Max Marks</th>
								<th colspan="2">Marks awarded by</th>
								<th rowspan="2"> 
									@if(!$view)
										Employee <br> Input 
									@endif
								</th>
							</tr>
							<tr class="text-center align-middle ">
								<th>Reporting Authority</th>
								<th>Reviewing Authority</th>
							</tr>
						</thead>
						<tbody>
							<tr class="bg-info fw-bold fs-5">
								<td class="text-white" colspan="6">4-A - Assessment of Performance</td>
							</tr>
							@foreach($requiredParameters as $required_parameter)
								@php
									if($required_parameter->applicable == 1){
										$total_marksA = $total_marksA + $required_parameter->max_marks;
										$classtext = "";
										$classButton = "";
										$reporting_marksA = $reporting_marksA + $required_parameter->reporting_marks;
										/*if($required_parameter->reporting_marks){
										}*/
										if($required_parameter->reviewing_marks){
											$reviewing_marksA = $reviewing_marksA + $required_parameter->reviewing_marks;
										}else{
											$reviewing_marksA = $reviewing_marksA + $required_parameter->reporting_marks;
										}
									}else{
										$classtext = "text-decoration-line-through";
										$classButton = "disabled placeholder=NA";
									}
								@endphp
								<tr class="{{$classtext??''}}">
									<td>{{$loop->iteration}}</td>
									<td>
										{{$required_parameter->description}}
									</td>
									<td class="text-center">
										{{$required_parameter->max_marks}}
									</td>
									<td class="text-center">
										{{$required_parameter->reporting_marks??''}}
									</td>
									<td class="text-end">
										@if($view)
										<span class="reviewingPositiveNo"> 
											{{$required_parameter->reviewing_marks??''}}
										</span>
										@else
											<input class="form-control form-control-sm text-end reviewingPositiveNo" type="number" step="0.01" name="reviewing_marks[{{$required_parameter->id}}]" {{$classButton??''}}
												@if($required_parameter->reviewing_marks)
													value="{{$required_parameter->reviewing_marks}}"
												@else
													value="{{$required_parameter->reporting_marks}}"
												@endif
											>
										@endif
									</td>
									<td>
										@if(!$view)
											 <a  class="btn" id="btn1" onclick="showData({{$required_parameter->id}})">
											 	<svg class="icon">
													<use xlink:href="{{url('vendors/@coreui/icons/svg/free.svg#cil-search')}}"></use>
												</svg>
											 </a>
										 @endif
									</td>
								</tr>
							@endforeach
							@php
								if($total_marksA>0){
									$net_reporting_marksA = 80*$reporting_marksA/$total_marksA;
									$net_reviewing_marksA = 80*$reviewing_marksA/$total_marksA;
								}else{
									$net_reporting_marksA = 0;
									$net_reviewing_marksA = 0;
								}
							@endphp
							<tr class="bg-light fw-bold">
								<td></td>
								<td class="text-end">Sum for 4- A</td>
								<td class="text-center">{{$total_marksA}}</td>
								<td class="text-center">{{$reporting_marksA??''}}</td>
								<td class="text-end" id="reviewingPositiveSum">{{$reviewing_marksA??''}}</td>
								<td></td>
							</tr>
							<tr class="bg-light fw-bold">
								<td></td>
								<td class="text-end">Say</td>
								<td class="text-center">80</td>
								<td class="text-center">
									{{$net_reporting_marksA}}
								</td>
								<td class="text-end reviewingPositiveNetSum">
									{{$net_reviewing_marksA}}
								</td>
								<td></td>
							</tr>
							<tr class="bg-info fw-bold fs-5">
								<td class="text-white" colspan="6">4-B - Assessment of Personal Attributes</td>
							</tr>
							@php
								$total_marksB = 0;
								$reporting_marksB = 0;
								$reviewing_marksB = 0;
							@endphp
							@foreach($personal_attributes as $personal_attribute)
								@php
									$total_marksB = $total_marksB + $personal_attribute->max_marks;
									$reporting_marksB = $reporting_marksB + $personal_attribute->reporting_marks;
									if($personal_attribute->reviewing_marks){
										$reviewing_marksB = $reviewing_marksB + $personal_attribute->reviewing_marks;
									}else{
										$reviewing_marksB = $reviewing_marksB + $personal_attribute->reporting_marks;
									}
								@endphp
								<tr>
									<td>{{$loop->iteration}}</td>
									<td>{{$personal_attribute->description}}</td>
									<td class="text-center">{{$personal_attribute->max_marks}}</td>
									<td class="text-center">
										{{$personal_attribute->reporting_marks??'0'}}
									</td>
									<td class="text-end">
										@if($view)
											{{$personal_attribute->reviewing_marks??'0'}}
										@else
											<input class="form-control form-control-sm text-end reportingPersonalNo" type="number" step="0.01" name="personal_attributes[{{$personal_attribute->id}}]"
												@if($personal_attribute->reviewing_marks)
													value="{{$personal_attribute->reviewing_marks}}" 
												@else
													value="{{$personal_attribute->reporting_marks}}" 
												@endif
											>
										@endif
									</td>
									<td></td>
								</tr>
							@endforeach
							<tr class="bg-light fw-bold">
								<td></td>
								<td class="text-end">Sum for 4- B</td>
								<td class="text-center">{{$total_marksB}}</td>
								<td class="text-center">{{$reporting_marksB??''}}</td>
								<td class="text-end reviewingPersonalSum">{{$reviewing_marksB??''}}</td>
								<td></td>
							</tr>
							<tr class="bg-info fw-bold fs-5">
								<td class="text-white" colspan="6">4-C - Deductions</td>
							</tr>
							@php
								$total_marksC =  $reporting_marksC = $reviewing_marksC = 0;
							@endphp
							@foreach($requiredNegativeParameters as $requiredNegativeParameter)
								@php
									$total_marksC = $total_marksC + $requiredNegativeParameter->max_marks;
									$reporting_marksC = $reporting_marksC + $requiredNegativeParameter->reporting_marks;
									if($requiredNegativeParameter->reviewing_marks){
											$reviewing_marksC = $reviewing_marksC + $requiredNegativeParameter->reviewing_marks;
									}else{
										$reviewing_marksC = $reviewing_marksC + $requiredNegativeParameter->reporting_marks;
									}
								@endphp
								<tr>
									<td>{{$loop->iteration}}</td>
									<td>{{$requiredNegativeParameter->description}}</td>
									<td class="text-center">{{$requiredNegativeParameter->max_marks}}</td>
									<td class="text-center">{{$requiredNegativeParameter->reporting_marks??'0'}}</td>
									<td class="text-end">
										@if($view)
											{{$requiredNegativeParameter->reviewing_marks??'0'}}
										@else
											<input class="form-control form-control-sm text-end reportingNegativeNo" type="number" step="0.01" name="reviewing_marks[{{$requiredNegativeParameter->id}}]"
											@if($requiredNegativeParameter->reviewing_marks)
												value="{{$requiredNegativeParameter->reviewing_marks}}"
											@else
												value="{{$requiredNegativeParameter->reporting_marks}}"
											@endif
											>
										@endif
									</td>
									<td>
										@if(!$view)
										 <a  class="btn" id="btn1" 
										 onclick="showNegativeData({{$requiredNegativeParameter->id}})" >view </a>
										@endif
									</td>
								</tr>
							@endforeach
							<tr class="bg-light fw-bold">
								<td></td>
								<td class="text-end">Sum for 4- C</td>
								<td class="text-center">{{$total_marksC}}</td>
								<td class="text-center">{{$reporting_marksC??''}}</td>
								<td class="text-end reportingNegativeSum">{{$reviewing_marksC??''}}</td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-body border border-2 border-danger">
				<p class="fw-semibold h5">5. Summary of Marks awarded</p>
				<table class="table table-bordered table-sm">
					<thead>
						<tr class="text-center align-middle fw-bold bg-light">
							<th>Description</th>
							<th class="text-center">Max. Marks</th>
							<th class="text-center">Marks awarded by <br> Reporting Authority</th>
							<th class="text-center">Marks awarded by <br> Reviewing Authority</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Assessment of work</td>
							<td class="text-center">80</td>
							<td class="text-center">{{$net_reporting_marksA}}</td>
							<td class="text-center reviewingPositiveNetSum" id="totalA">{{$net_reviewing_marksA}}</td>
						</tr>
						<tr>
							<td>Assessment of personal attributes</td>
							<td class="text-center">{{$total_marksB}}</td>
							<td class="text-center">{{$reporting_marksB}}</td>
							<td class="text-center reviewingPersonalSum" id="totalB">{{$reviewing_marksB??'0'}}</td>
						</tr>
						<tr>
							<td>Deduction (max {{$total_marksC}})</td>
							<td class="text-center"></td>
							<td class="text-center">{{$reporting_marksC??'0'}}</td>
							<td class="text-center reportingNegativeSum" id="totalC">{{$reviewing_marksC??'0'}}</td>
						</tr>
						<tr class="bg-light fw-bold fs-5">
							<td class="text-end">Net</td>
							<td class="text-center">{{80 + $total_marksB}}</td>
							<td class="text-center">{{$net_reporting_marksA+ $reporting_marksB - $reporting_marksC}}</td>
							<td class="text-center" id="Nettotal">{{$net_reviewing_marksA+ $reviewing_marksB - $reviewing_marksC}}</td>
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
			@if(!$view)
				<div class="form-group mt-2">
			        <button type="submit" class="btn btn-primary">Save
			    </div>
			@endif
		</form>
		
	</div>
	<!-- boostrap model -->
	<div class="modal fade" id="user_data_model" aria-hidden="true" tabindex="-1" role="dialog">
		<div class="modal-dialog" style="width: auto; max-width: 80%; margin: 2rem auto;" role="document">
			<div class="modal-content">
				<div class="modal-body" id="user_input_data">
					{{-- data from ajax --}}
				</div>
			</div>
		</div>
	</div>
	<!-- end bootstrap model -->
@endsection

@section('footscripts')
	@include('layouts._commonpartials.js._select2')
	<script type="text/javascript">
		// real time calcuation of Positive Numbers
		$(".reviewingPositiveNo").on('change keydown paste input', function(){
		    calcuationPositiveNumbers();
		    calcuationNetTotal();
		});
		$(".reportingPersonalNo").on('change keydown paste input', function(){
		    calcuationPersonalNumbers();
		    calcuationNetTotal();
		});
		$(".reportingNegativeNo").on('change keydown paste input', function(){
		    calcuationNegativeNumbers();
		    calcuationNetTotal();
		});


		

		function calcuationPositiveNumbers(){
			var sum = 0;
		    var marksA = {{$total_marksA}};
			$('.reviewingPositiveNo').each(function(){
			    sum = sum + (this.value)*1;
			});
			$("#reviewingPositiveSum").html(sum);
			if (marksA > 0) {
				$(".reviewingPositiveNetSum").html( (80*sum/marksA).toFixed(0) );
			} 
		}

		function calcuationPersonalNumbers(){
			var sum = 0;
		    var marksB = {{$total_marksB}};
			$('.reportingPersonalNo').each(function(){
			    sum = sum + (this.value)*1;
			});
			$(".reviewingPersonalSum").html(sum.toFixed(2));
			
		}

		function calcuationNegativeNumbers(){
			var sum = 0;
		    var marksB = {{$total_marksB}};
			$('.reportingNegativeNo').each(function(){
			    sum = sum + (this.value)*1;
			});
			$(".reportingNegativeSum").html(sum.toFixed(2));
			
		}

		function calcuationNetTotal(){
			var A = $('#totalA').text();
			var B = $('#totalB').text();
			var C = $('#totalC').text();
			$("#Nettotal").html((A*1+B*1- C*1).toFixed(2));
		}

		
		function showData(paramId)
		{
			$.ajax
			({
				url: '{{ url('cr/getUserParameterData') }}/' + {{$acr->id}} + '/' + paramId,
				type: 'GET',
				success: function (data) {
					 $("#user_input_data").html(data);
					 $('#user_data_model').modal('show');
				}
			});
		}

		function showNegativeData(paramId)
		{
			$.ajax
			({
				url: '{{ url('cr/getUserNegativeParameterData') }}/' + {{$acr->id}} + '/' + paramId,
				type: 'GET',
				success: function (data) {
					 $("#user_input_data").html(data);
					 $('#user_data_model').modal('show');
				}
			});
		}

	</script>
@endsection
