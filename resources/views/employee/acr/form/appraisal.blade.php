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
    {{-- @php $view = true; @endphp --}}
    {{-- @php $view = false; @endphp --}}
	<div class="card">
		<form class="form-horizontal" method="POST" action="{{route('acr.form.storeAppraisal1')}}">
			@csrf
			<input type="hidden" name="acr_id" value='{{$acr->id}}'>
			<div class="card-body border border-2 border-info">
					<div class="form-group">
					<p class="fw-semibold h5">
					  	1. Please state whether you agree with the responses relating to the accomplishments of the work plan and unforeseen tasks as filled out in Section II. If not please furnish factual details.
					</p>
					@if($view)
						<p class="text-info">{{$acr->appraisal_note_1??'--'}}</p>
					@else
						<textarea class="form-control rounded-3" id="appraisal_note_1"  name="appraisal_note_1" 
						  	@if(!empty($acr->appraisal_note_1))
								style="background-color:#F0FFF0;"
							@endif
						>{{$acr->appraisal_note_1}}</textarea>
					@endif
				  	<p class="fw-semibold h5">
				  		2. Please comment on the claim(if made) of exceptional contribution by the officer reoorted upon.
				  	</p>
				  	@if($view)
						<p class="text-info">{{$acr->appraisal_note_1??'--'}}</p>
					@else
					  	<textarea class="form-control rounded-3" id="appraisal_note_2"  name="appraisal_note_2" rows="3"
					  	@if(!empty($acr->appraisal_note_2))
								style="background-color:#F0FFF0;"
							@endif
						>{{$acr->appraisal_note_2??''}}</textarea>

					@endif
				  	<p class="fw-semibold h5">
				  		3. Has the officer reported upon met with any significant failures in respect of his work? If yes, Please furnish factual details.
				  	</p>

				  	@if($view)
						<p class="text-info">{{$acr->appraisal_note_1??'--'}}</p>
					@else
					  	<textarea class="form-control rounded-3" id="appraisal_note_3"  name="appraisal_note_3" rows="3"
					  		@if(!empty($acr->appraisal_note_3))
								style="background-color:#F0FFF0;"
							@endif
						>{{$acr->appraisal_note_3??''}}</textarea>
					@endif
				  	
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
								<th>Marks awarded by <br>Reporting Authority</th>
								<th>
								@if(!$view)
								 	Employee<br>Input 
								@endif
								</th>
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
										if($required_parameter->reporting_marks){
											$reporting_marksA = $reporting_marksA + $required_parameter->reporting_marks;
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
									<td class="text-end">
										@if($view)
										<span class="reportingPositiveNo"> 
											{{$required_parameter->reporting_marks??''}}
										</span>
										@else
											<input class="form-control form-control-sm text-end reportingPositiveNo" type="number" step="0.01" 
											 min="0" max="{{$required_parameter->max_marks}}"
											name="reporting_marks[{{$required_parameter->id}}]" {{$classButton??''}}
												@if($required_parameter->reporting_marks)
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
												show
											 </a>
										 @endif
									</td>
								</tr>
							@endforeach
							@php
								if($total_marksA>0){
									$net_marksA = 80*$reporting_marksA/$total_marksA;
								}else{
									$net_marksA = 0;
								}
							@endphp
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
									{{$net_marksA}}
								</td>
								<td></td>
							</tr>
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
									if($personal_attribute->reporting_marks){
										$reporting_marksB = $reporting_marksB + $personal_attribute->reporting_marks;
									}
								@endphp
								<tr>
									<td>{{$loop->iteration}}</td>
									<td>{{$personal_attribute->description}}</td>
									<td class="text-center">{{$personal_attribute->max_marks}}</td>
									<td class="text-end">
										@if($view)
											{{$personal_attribute->reporting_marks??'--'}}
										@else
											<input class="form-control form-control-sm text-end reportingPersonalNo" type="number" step="0.01" name="personal_attributes[{{$personal_attribute->id}}]"
												@if($personal_attribute->reporting_marks)
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
										@if($view)
											{{$requiredNegativeParameter->reporting_marks??'--'}}
										@else
											<input class="form-control form-control-sm text-end reportingNegativeNo" type="number" step="0.01" name="reporting_marks[{{$requiredNegativeParameter->id}}]"
											@if($requiredNegativeParameter->reporting_marks)
												value="{{$requiredNegativeParameter->reporting_marks}}"
											@endif
											>
										@endif
									</td>
									<td>
										@if(!$view)
											<a  class="btn" id="btn1" onclick="showNegativeData({{$requiredNegativeParameter->id}})" >
												<svg class="icon">
													<use xlink:href="{{url('vendors/@coreui/icons/svg/free.svg#cil-search')}}"></use>
												</svg>
												show 
											</a>
										@endif
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
				<input 	type="hidden" name="final_marks"
						value="{{$net_marksA+ $reporting_marksB - $reporting_marksC}}"
				>
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
							<td class="text-center reportingPositiveNetSum" id="totalA">{{$net_marksA}}</td>
						</tr>
						<tr>
							<td>Assessment of personal attributes</td>
							<td class="text-center">{{$total_marksB}}</td>
							<td class="text-center reportingPersonalSum" id="totalB">{{$reporting_marksB??'0'}}</td>
						</tr>
						<tr>
							<td>Deduction (max {{$total_marksC}})</td>
							<td class="text-center"></td>
							<td class="text-center reportingNegativeSum" id="totalC">{{$reporting_marksC??'0'}}</td>
						</tr>
						<tr class="bg-light fw-bold fs-5">
							<td class="text-end">Net</td>
							<td class="text-center">{{80 + $total_marksB}}</td>
							<td class="text-center" id="Nettotal">{{$net_marksA+ $reporting_marksB - $reporting_marksC}}</td>
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
		$(".reportingPositiveNo").on('change keydown paste input', function(){
		    calcuationPositiveNumbers();
		    calcuationNetTotal();
		    //$(".reportingPositiveNetSum").html((($("#totalA").value)*1 + ($("#totalB").value)*1 - ($("#totalA").value)*1));
		});
		$(".reportingPersonalNo").on('change keydown paste input', function(){
		    calcuationPersonalNumbers();
		    calcuationNetTotal();
		    //$(".reportingPositiveNetSum").html( ($("#totalA").value + $("#totalB").value - $("#totalA").value).toFixed(0) );

		});
		$(".reportingNegativeNo").on('change keydown paste input', function(){
		    calcuationNegativeNumbers();
		    calcuationNetTotal();
		    //$(".reportingPositiveNetSum").html( ($("#totalA").value + $("#totalB").value - $("#totalA").value).toFixed(0) );

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

		

		function calcuationPositiveNumbers(){
			var sum = 0;
		    var marksA = {{$total_marksA}};
			$('.reportingPositiveNo').each(function(){
			    sum = sum + (this.value)*1;
			});
			$("#reportingPositiveSum").html(sum);
			if (marksA > 0) {
				$(".reportingPositiveNetSum").html( (80*sum/marksA).toFixed(0) );
			} 
		}

		function calcuationPersonalNumbers(){
			var sum = 0;
		    var marksB = {{$total_marksB}};
			$('.reportingPersonalNo').each(function(){
			    sum = sum + (this.value)*1;
			});
			$(".reportingPersonalSum").html(sum.toFixed(2));
			
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

		
	</script>
@endsection
