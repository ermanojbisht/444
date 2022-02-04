@extends('layouts.type200.main')
@section('sidebarmenu')
	@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection
@section('pagetitle')
	Part -III Appraisal <small>Form -1</small>
@endsection
@section('content')
	@include('employee.acr.form._formHeader',['acr'=>$acr])
	<div class="card">
		<div class="card-body border border-2 border-info">
			<form class="form-horizontal" method="POST" action="{{route('acr.form.storeAppraisal1')}}">
				@csrf
				<input type="hidden" name="acr_id" value='{{$acr->id}}'>
				<div class="form-group">
					<label for="appraisal_note_1" class="fw-bold h5">
					  	1. Please state whether you agree with the responses relating to the accomplishments of the work plan and unforeseen tasks as filled out in Section II. If not please furnish factual details.
					</label>
					<textarea class="form-control rounded-3" id="appraisal_note_1"  name="appraisal_note_1" rows="3"
					  	@if(!empty($acr->appraisal_note_1))
							style="background-color:#F0FFF0;"
						@endif
					>{{$acr->appraisal_note_1??''}}</textarea>
				  	<label for="appraisal_note_2" class="fw-bold h5">
				  		2. Please comment on the claim(if made) of exceptional contribution by the officer reoorted upon.
				  	</label>
				  	<textarea class="form-control rounded-3" id="appraisal_note_2"  name="appraisal_note_2" rows="3"
				  	@if(!empty($acr->appraisal_note_2))
							style="background-color:#F0FFF0;"
						@endif
					>{{$acr->appraisal_note_2??''}}</textarea>
				  	<label for="appraisal_note_3" class="fw-bold h5">
				  		3. Has the officer reported upon met with any significant failures in respect of his work? If yes, Please furnish factual details.
				  	</label>
				  	<textarea class="form-control rounded-3" id="appraisal_note_3"  name="appraisal_note_3" rows="3"
				  	@if(!empty($acr->appraisal_note_3))
							style="background-color:#F0FFF0;"
						@endif
					>{{$acr->appraisal_note_3??''}}</textarea>
				</div>

			<div class="form-group mt-2 text-end">
		        <button type="submit" class="btn btn-primary">Save
		    </div>
			</form>
		</div>
		<div class="card-body border border-2 border-success">
			<form class="form-horizontal" method="POST" action="{{route('acr.form.storeAppraisal1')}}">
				@csrf
				<input type="hidden" name="acr_id" value='{{$acr->id}}'>
				<div class="form-group">
					@php $total_marksA = 0; @endphp
					<table class="table table-bordered table-sm">
						<thead class="bg-info ">
							<tr class="text-center align-middle ">
								<th>#</th>
								<th>Parameter</th>
								<th>Max Marks</th>
								<th>Marks awarded by <br>Reporting Authority</th>
								<th> Employee Input </th>
							</tr>
						</thead>
						<tbody>
							<tr class="bg-info fw-bold fs-5">
								<td class="text-white" colspan="1">4- A</td>
								<td class="text-white" colspan="4">Assessment of Performance</td>
							</tr>
							@foreach($requiredParameters as $requiredParameters)
								<tr>
									<td>{{$loop->iteration}}</td>
									<td>
										@if($notApplicableParameters->contains($requiredParameters->id))
												<span class ="text-danger text-decoration-line-through">
													{{$requiredParameters->description}} 
												</span>
												Not Applicable
										@else
												{{$requiredParameters->description}}
												@php
													$total_marksA = $total_marksA + $requiredParameters->max_marks;
												@endphp
										@endif
									</td>
									<td class="text-center">{{$requiredParameters->max_marks}}</td>
									<td>
										<input class="form-control text-end" type="number" step="0.01" name="reporting_marks[{{$requiredParameters->id}}]">
									</td>
									<td>
										 <a  class="btn" id="btn1" 
										 onclick="showData({{$requiredParameters->id}})" >view </a>
									</td>
								</tr>
							@endforeach
							<tr class="bg-light fw-bold">
								<td></td>
								<td class="text-end">Sum for 4- A</td>
								<td class="text-center">{{$total_marksA}}</td>
								<td></td>
								<td></td>
							</tr>
							<tr class="bg-info fw-bold fs-5">
								<td class="text-white" colspan="1">4- B</td>
								<td class="text-white" colspan="4">Assessment of Personal Attributes</td>
							</tr>
							@php
								$total_marksB = 0;
							@endphp
							@foreach($personal_attributes as $personal_attribute)
								@php
									$total_marksB = $total_marksB + $personal_attribute->max_marks;
								@endphp
								<tr>
									<td>{{$loop->iteration}}</td>
									<td>{{$personal_attribute->description}}</td>
									<td class="text-center">{{$personal_attribute->max_marks}}</td>
									<td>
										<input class="form-control text-end" type="number" step="0.01" name="attribute_marks[{{$personal_attribute->id}}]">
									</td>
									<td></td>
								</tr>
							@endforeach
							<tr class="bg-light fw-bold">
								<td></td>
								<td class="text-end">Sum for 4- B</td>
								<td class="text-center">{{$total_marksB}}</td>
								<td></td>
								<td></td>
							</tr>
							<tr class="bg-info fw-bold fs-5">
								<td class="text-white" colspan="1">4- C</td>
								<td class="text-white" colspan="4">Deductions</td>
							</tr>
							@php
								/*$total_marksC = 0;*/
							@endphp
							@foreach($requiredNegativeParameters as $requiredNegativeParameter)
								<tr>
									<td>{{$loop->iteration}}</td>
									<td>{{$requiredNegativeParameter->description}}</td>
									<td class="text-center">{{$requiredNegativeParameter->max_marks}}</td>
									<td>
										<input class="form-control text-end" type="number" step="0.01" name="reporting_marks[{{$requiredNegativeParameter->id}}]">
									</td>
									<td>
										 <a  class="btn" id="btn1" 
										 onclick="showNegativeData({{$requiredNegativeParameter->id}})" >view </a>
									</td>
								</tr>
							@endforeach
							<tr class="bg-light fw-bold">
								<td></td>
								<td class="text-end">Sum for 4- C</td>
								<td class="text-center"></td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
						<tfoot>
							
						</tfoot>
					</table>
				</div>
			</form>
		</div>
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
