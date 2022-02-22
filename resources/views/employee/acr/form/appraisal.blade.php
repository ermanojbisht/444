@extends('layouts.type200.main')
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection
@section('pagetitle')
Part -III Appraisal <small>(By Reporting Officer)</small>
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
	['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
	['label'=> 'Inbox','route'=>
	'acr.others.index', 'active'=>false],
	['label'=> 'Appraisal By Reporting Officer','active'=>true]
]])

@endsection

@section('content')

<div class="card">
	<form class="form-horizontal" method="POST" action="{{route('acr.form.storeAppraisal1')}}">
		@csrf
		<input type="hidden" name="acr_id" value='{{$acr->id}}'>
		<div class="card-body border border-2 border-info">
			<div class="form-group">
				<p class="fw-semibold h5">
					1. Please state whether you agree with the responses relating to the accomplishments of the work
					plan and unforeseen tasks as filled out in Section II. If not please furnish factual details.
				</p>
				<textarea class="form-control rounded-3" id="appraisal_note_1" name="appraisal_note_1" @if(!empty($acr->appraisal_note_1))
								style="background-color:#F0FFF0;"
							@endif
						>{{$acr->appraisal_note_1??''}}</textarea>
				<p class="fw-semibold h5">
					2. Please comment on the claim(if made) of exceptional contribution by the officer reoorted upon.
				</p>
				<textarea class="form-control rounded-3" id="appraisal_note_2" name="appraisal_note_2" rows="3"
					@if(!empty($acr->appraisal_note_2))
								style="background-color:#F0FFF0;"
							@endif
						>{{$acr->appraisal_note_2??''}}</textarea>

				<p class="fw-semibold h5">
					3. Has the officer reported upon met with any significant failures in respect of his work? If yes,
					Please furnish factual details.
				</p>
				<textarea class="form-control rounded-3" id="appraisal_note_3" name="appraisal_note_3" rows="3"
					@if(!empty($acr->appraisal_note_3))
								style="background-color:#F0FFF0;"
							@endif
						>{{$acr->appraisal_note_3??''}}</textarea>
			</div>
		</div>
		<div class="card-body border border-2 border-success">
			<div class="form-group">
				@php $total_marksA = $reporting_marksA = 0; @endphp
				<table class="table table-bordered table-sm">
					<thead class="bg-info ">
						<tr class="text-center align-middle ">
							<th>#</th>
							<th>Parameter</th>
							<th>Max Marks</th>
							<th>Marks awarded by<br>Reporting Authority</th>
							<th>Employee<br>Input</th>
						</tr>
					</thead>
					<tbody>
						<tr class="bg-info fw-bold fs-5">
							<td class="text-white" colspan="5">4-A - Assessment of Performance</td>
						</tr>
						@foreach($requiredParameters as $required_parameter)
						@php
						if($required_parameter->applicable == 1){
							$total_marksA = $total_marksA + $required_parameter->max_marks;
							$classtext = "";
							$classButton = "";
							$reporting_marksA = $reporting_marksA + $required_parameter->reporting_marks??0;
						}else{
							$classtext = "text-decoration-line-through";
							$classButton = "disabled placeholder=NA";
						}
						@endphp
						<tr class="{{$classtext??''}}">
							<td> {{$loop->iteration}} </td>
							<td> {{$required_parameter->description}} </td>
							<td class="text-center"> {{$required_parameter->max_marks}} </td>
							<td class="text-end">
								<input class="form-control form-control-sm text-end reportingPositiveNo" type="number"
									step="0.01" min="0" max="{{$required_parameter->max_marks}}"
									name="reporting_marks_positive[{{$required_parameter->id}}]" {{$classButton??''}}
									@if($applicableParameters != 0)
										value="{{$required_parameter->reporting_marks??''}}"
									@endif
								>
							</td>
							<td>
								<a class="btn" id="btn1" onclick="showData({{$required_parameter->id}})">
									<svg class="icon">
										<use xlink:href="{{url('vendors/@coreui/icons/svg/free.svg#cil-search')}}">
										</use>
									</svg>
									show
								</a>
							</td>
						</tr>
						@endforeach
						@php
							if($total_marksA > 0){
								$positive_factor = 80/$total_marksA;
							}else{
								$positive_factor = 0;
							}
							$net_marksA = $positive_factor*$reporting_marksA;
						@endphp
						<input type="hidden" name="positive_factor" value="{{$positive_factor}}">
						
						@if($applicableParameters == 0)
						<tr class="bg-danger fw-bold" id="exceptional_row">
							<td></td>
							<td class="text-end">User Declare all Parameters as not Applicable You may Give Number here </td>
							<td class="text-center">80</td>
							<td class="text-end">
								<input class="form-control form-control-sm text-end" type="number"
									id="exceptional_reporting_marks"
									step="0.01" min="0" max="80"
									name="exceptional_reporting_marks"
									value="{{$exceptional_reporting_marks}}" 
								>
							</td>
							<td></td>
						</tr>
						@else
						<tr class="bg-light fw-bold">
							<td></td>
							<td class="text-end">Sum for 4- A</td>
							<td class="text-center">{{$total_marksA}}</td>
							<td class="text-end" id="reportingPositiveSum">{{$reporting_marksA??''}}</td>
							<td></td>
						</tr>
						<tr class="bg-light fw-bold">
							<td></td>
							<td class="text-end">Say</td>
							<td class="text-center">80</td>
							<td class="text-end reportingPositiveNetSum">
								{{number_format(round($net_marksA,2),2)}}
							</td>
							<td></td>
						</tr>
						@endif
						
						<tr class="bg-info fw-bold fs-5">
							<td class="text-white" colspan="5">4-B - Assessment of Personal Attributes</td>
						</tr>
						@php
							$total_marksB = 0;
							$reporting_marksB = 0;
						@endphp
						@foreach($personal_attributes as $personal_attribute)
							@php
								$total_marksB = $total_marksB + $personal_attribute->max_marks;
								$reporting_marksB = $reporting_marksB + $personal_attribute->reporting_marks??0;
							@endphp
							<tr>
								<td>{{$loop->iteration}}</td>
								<td>{{$personal_attribute->description}}</td>
								<td class="text-center">{{$personal_attribute->max_marks}}</td>
								<td class="text-end">
									<input class="form-control form-control-sm text-end reportingPersonalNo" type="number"
										step="0.01" name="personal_attributes[{{$personal_attribute->id}}]" min="0"
										max="{{$personal_attribute->max_marks}}"
										value="{{$personal_attribute->reporting_marks??''}}"
									>
								</td>
								<td></td>
							</tr>
						@endforeach
						<tr class="bg-light fw-bold">
							<td></td>
							<td class="text-end">Sum for 4- B</td>
							<td class="text-center">{{$total_marksB}}</td>
							<td class="text-end reportingPersonalSum">{{$reporting_marksB??''}}</td>
							<td></td>
						</tr>
						<tr class="bg-info fw-bold fs-5">
							<td class="text-white" colspan="5">4-C - Deductions</td>
						</tr>
						@php
							$reporting_marksC = 0;
							$total_marksC = 0;
						@endphp
						@foreach($requiredNegativeParameters as $requiredNegativeParameter)
							@php
							$total_marksC = $total_marksC + $requiredNegativeParameter->max_marks;
							if($requiredNegativeParameter->reporting_marks){
							$reporting_marksC = $reporting_marksC + $requiredNegativeParameter->reporting_marks;
							}
							@endphp
							<tr>
								<td>{{$loop->iteration}}</td>
								<td>{{$requiredNegativeParameter->description}}</td>
								<td class="text-center">{{$requiredNegativeParameter->max_marks}}</td>
								<td class="text-end">
									<input class="form-control form-control-sm text-end reportingNegativeNo" type="number"
										step="0.01" min="0"
										max="{{$requiredNegativeParameter->max_marks}}"
										name="reporting_marks_negative[{{$requiredNegativeParameter->id}}]"
										@if($requiredNegativeParameter->reporting_marks)
									value="{{$requiredNegativeParameter->reporting_marks}}"
									@endif
									>
								</td>
								<td>
									<a class="btn" id="btn1" onclick="showNegativeData({{$requiredNegativeParameter->id}})">
										<svg class="icon">
											<use xlink:href="{{url('vendors/@coreui/icons/svg/free.svg#cil-search')}}">
											</use>
										</svg>
										show
									</a>
								</td>
							</tr>
						@endforeach
						<tr class="bg-light fw-bold">
							<td></td>
							<td class="text-end">Sum for 4- C</td>
							<td class="text-center">{{$total_marksC}}</td>
							<td class="text-end reportingNegativeSum">{{$reporting_marksC??''}}</td>
							<td></td>
						</tr>
					</tbody>
					<tfoot>

					</tfoot>
				</table>
			</div>
		</div>
		<div class="card-body border border-2 border-danger">
			<p class="fw-semibold h5">5. Summary of Marks awarded</p>
			<table class="table table-bordered table-sm">
				<thead>
					<tr class="text-center align-middle">
						<th>Description</th>
						<th class="text-center">Max. Marks</th>
						<th class="text-center">Marks awarded by <br> Reporting Authority</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Assessment of work</td>
						<td class="text-center">80</td>
						<td class="text-center reportingPositiveNetSum" id="totalA">
							@if($applicableParameters != 0)
								{{number_format(round($net_marksA,2),2)}}
							@else
								{{number_format(round($exceptional_reporting_marks,2),2)}}
							@endif
						</td>
					</tr>
					<tr>
						<td>Assessment of personal attributes</td>
						<td class="text-center">{{$total_marksB}}</td>
						<td class="text-center reportingPersonalSum" id="totalB">
							{{number_format(round($reporting_marksB??'0',2),2)}}
						</td>
					</tr>
					<tr>
						<td>Deduction (max {{$total_marksC}})</td>
						<td class="text-center"></td>
						<td class="text-center reportingNegativeSum" id="totalC">
							{{number_format(round($reporting_marksC??'0',2),2)}}
						</td>
					</tr>
					<tr class="bg-light fw-bold fs-5">
						<td class="text-end">Net</td>
						<td class="text-center">{{80 + $total_marksB}}</td>
						<td class="text-center" id="Nettotal">
							@if($applicableParameters != 0)
								{{number_format(round($net_marksA+ $reporting_marksB - $reporting_marksC,2),2)}}
							@else
								{{number_format(round($exceptional_reporting_marks+ $reporting_marksB - $reporting_marksC,2),2)}}
							@endif
							
						</td>
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
		<div class="form-group mt-2">
			<button type="submit" class="btn btn-primary">Save
		</div>
	</form>

</div>
<!-- boostrap model -->
<div class="modal fade" id="user_data_model" aria-hidden="true" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered  modal-xl" style="width: auto; " role="document">
		<div class="modal-content">
			<div class="modal-body border border-2 border-info p-1 " id="user_input_data">
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
		// real time calcuation of Numbers
		$(".reportingPositiveNo, .reportingPersonalNo, .reportingNegativeNo, #exceptional_reporting_marks").on('change keydown paste input', function(){

		    var sumA = 0;
		    var sumB = 0;
		    var sumC = 0;

			// Sum of All Positive Parameter Nos
			$('.reportingPositiveNo').each(function(){ sumA = sumA + (this.value)*1; });
			$("#reportingPositiveSum").html(sumA);
			
			// Net of All Positive Parameter Nos
			if ({{$positive_factor}} > 0) {
				$(".reportingPositiveNetSum").html( (80*sumA/{{$total_marksA}}).toFixed(2) );
			}else{
				var inputVal = document.getElementById("exceptional_reporting_marks").value;
				$(".reportingPositiveNetSum").html(inputVal);
			}

			// Calculate Persional Attribue Numbers
			$('.reportingPersonalNo').each(function(){ sumB = sumB + (this.value)*1; });
			$(".reportingPersonalSum").html(sumB.toFixed(2));

			// Calculate Negative Numbers
			$('.reportingNegativeNo').each(function(){ sumC = sumC + (this.value)*1; });
			$(".reportingNegativeSum").html(sumC.toFixed(2));

		    var A = $('#totalA').text();
			var B = $('#totalB').text();
			var C = $('#totalC').text();
			$("#Nettotal").html((A*1+B*1- C*1).toFixed(2));
		});


		function showData(paramId)
		{
			$.ajax
			({
				url: '{{ url('acr/getUserParameterData') }}/' + {{$acr->id}} + '/' + paramId,
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
				url: '{{ url('acr/getUserNegativeParameterData') }}/' + {{$acr->id}} + '/' + paramId,
				type: 'GET',
				success: function (data) {
					 $("#user_input_data").html(data);
					 $('#user_data_model').modal('show');
				}
			});
		}
		
</script>
@endsection