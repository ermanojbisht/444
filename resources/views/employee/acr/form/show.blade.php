@extends('layouts.type200.pdf')
@section('content')
	<div class="card">
		<div class="card-body ">
				@foreach($data_groups as $groupId => $datas)
					@php
						$groupData = config('acr.group')[$groupId];
					@endphp
					<div>
						<p class="fw-semibold h5">{!!$groupData['head']!!}</p>
						<p class="fw-semibold h5">{{$groupData['head_note']}}</p>
						<p class="fw-semibold h6">{{$groupData['foot_note']}}</p>
					</div>	
					@php
						$table_type = $groupData['table_type'];
						$total_marks = 0;
					@endphp
						<table class="table">
							<thead class="bg-info">
								<tr class="text-center">
									<th>#</th>
									<th>Parameter</th>
									<th>Max Marks</th>
								@if($table_type == 1)
									<th>Unit</th>
									<th>Target</th>
									<th>Target Achived</th>
								@endif
								@if($table_type == 2)
									<th>Status of Progress</th>			
								@endif
									<th>Applicable</th>
								</tr>
							</thead>
							<tbody>
								@foreach($datas as $data)								
									@php 
										$total_marks = $total_marks + $data->max_marks;
									@endphp
									<tr>
										<td>{{$loop->iteration}}</td>
										<td>{{$data->description}}</td>
										<td class="text-center">{{$data->max_marks}}</td>
										@if($table_type == 1)
											<td class="text-center">{{$data->unit}}</td>
											<td class="text-center">
												{{$data->user_target??''}}
											</td>
											<td class="text-center">
												{{$data->user_achivement??''}}
											</td>
										@endif
										@if($table_type == 2)
											<td class="text-end">
													{{$data->status??''}}
											</td>
										@endif
										<td class="text-center">
											@if($data->applicable != 0)
												Yes
											@else
												No
											@endif
										</td>
									</tr>		
								@endforeach
							</tbody>
							<tfoot>
								<tr class="fw-bold">
									<td></td>
									<td>Total</td>
									<td class="text-center">{{$total_marks}}</td>
								</tr>
							</tfoot>
						</table>
				@endforeach
		</div>
		<div class="card-body">
			<p class="fw-semibold h5">
			  	2- Exceptionally good works done, if any, apart from routine duties during the period of appraisal
			</p>
			<p class="text-info">{{$acr->good_work??'--no data filled--'}}</p>
		  	<p class="fw-semibold h5">
		  		3- Difficulties faced in performing the assigned 'Tasks/Duties'
		  	</p>
		  	<p class="text-info">{{$acr->difficultie??'--no data filled--'}}</p>
		</div>
		<div class="card-body">
			@php
				$slno = 0;
			@endphp	
			@foreach($negative_groups as $groupId => $datas)
				@if($groupId < 3000)
					@foreach($datas as $data)
						
						@php
							$groupData = config('acr.group')[$groupId];
							$slno = $slno+1;
						@endphp
						<p class="fw-semibold h5 text-info">
							4.{{$slno}}- {!!$data->description!!}
							<span class="float-end small">maximum deduction - {{$data->max_marks}}</span>
						</p>
						<p class="fw-semibold text-primary ">{{$groupData['head_note']}}</p>
						<table class="table table-bordered border-primary">
							<thead class="table-info fw-semibold border-primary">
								<tr class="text-center align-middle">
									@foreach($groupData['columns'] as $key=>$values)
										<th>{{$values['text']}}</th>
									@endforeach
									<td></td>
								</tr>
							</thead>
							<tbody>
								@if($groupData['multi_rows'])
									@php $n = 0; @endphp
									@foreach($data->user_filled_data as $filled_data)
										@php  $n = $n+1; @endphp
										<tr style="background-color:#F0FFF0;">
											@foreach($groupData['columns'] as $key=>$values)
												<td>
													@if ($values['input_type'])
														
															{{$filled_data[$values['input_name']]??'--'}}
														
													@else
														{{$filled_data->row_no}}
													@endif
												</td>
											@endforeach

											<td>
												
											</td>
										<tr>
									@endforeach
								@else
									@if(!empty($data->user_filled_data[0]))
										<tr style="background-color:#F0FFF0;">
									@else
										<tr>
									@endif
										@foreach($groupData['columns'] as $key=>$values)
											<td>
												@if ($values['input_type'])
														{{$data->user_filled_data[0][$values['input_name']]??'--'}}
												@endif
											</td>
										@endforeach
											<td>
											
											</td>
										</tr>
								@endif
							</tbody>
						</table>
						
					@endforeach
				@else
					
					@php $slno = $slno+1; @endphp
					<p class="fw-semibold h5 text-info">4.{{$slno}}-  {!!config('acr.group')[$groupId]['head']!!}</p>
					<table class="table table-bordered border-primary">
						<thead class="table-info fw-semibold border-primary">
							<tr class="text-center align-middle">
								<th width="auto">Sl No.</th>
								<th width="auto">Description</th>
								<th width="50%">Action Taken</th>
								<th width="auto" class="text-info">max. deduction</th>
							</tr>
						</thead>
						<tbody>
							@foreach($datas as $data)
							<input type="hidden" name="acr_master_parameter_id[]" value='{{$data->id}}'>
								@if(!empty($data->user_filled_data[0]))
									<tr style="background-color:#F0FFF0;">
								@else
									<tr>
								@endif
									<td>
										{{$loop->iteration}}
									</td>
									<td>
										{{$data->description}}
									</td>
									<td>
										{{$data->user_filled_data[0]['col_1']??''}}
										
									</td>
									<td class="text-center align-middle text-info">
										{{$data->max_marks}}
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					
				@endif
			@endforeach
		</div>
		<div class="card-body">
			@foreach($master_trainings as $key=>$trainings)
			<div class="card-body">
				<P class="fw-semibold h5 text-muted">
					{{$key}}
				</P>
				<div class="row">
					@foreach($trainings as $training)
						<div class="form-check col-md-4  fs-5">
						  <input class="form-check-input" type="checkbox" value="{{$training->id}}" name="training[]" id="training{{$training->id}}" 
 								@if ($selected_trainings->contains($training->id))
							  		checked
							  	@endif
						  >
						  <label class="form-check-label" for="training{{$training->id}}">
						    {{$training->description}}
						  </label>
						</div>
					@endforeach
				</div>
			</div>
			<hr>
			@endforeach
		</div>
	</div>
@endsection