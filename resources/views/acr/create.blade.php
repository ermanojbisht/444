@extends('layouts.type200.main')
@section('content')
{{$acr->type->description}}
<hr>
<div class="card">
	<div class="card-body">
		<form class="form-horizontal" method="POST" action="{{route('temp.store')}}">
		    @csrf
			<input type="hidden" name="acr_id" value='{{$acr->id}}'/>	
			@foreach($data_groups as $groupId => $datas)
				@php
					$groupData = config('acr.group')[$groupId];
				@endphp
				<div>
					<p class="fw-bold h4">{!!$groupData['head']!!}</p>
					<p class="fw-bold h6">{{$groupData['head_note']}}</p>
					<p class="text-danger">*Please Ensure to Select NO on Dropdown for Parameters Not Applicable</p>
					<p class="fw-bold h6">{{$groupData['foot_note']}}</p>
				</div>	
				<div class="form-control">
					@php
						$table_type = $groupData['table_type'];
						$total_marks = 0;
					@endphp
						<table class="table">
							<thead>
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
									<input type="hidden" name="acr_master_parameter_id[]" value='{{$data->id}}'>
									<tr>
										<td>{{$loop->iteration}}</td>
										<td>{{$data->description}}</td>
										<td class="text-center">{{$data->max_marks}}</td>
								@if($table_type == 1)
										<td class="text-center">{{$data->unit}}</td>
										<td><input class="form-control" type="text" name="target[{{$data->id}}]"/></td>
										<td><input class="form-control" type="text" name="achivement[{{$data->id}}]"/></td>
								@endif
								@if($table_type == 2)
										<td><input class="form-control" type="text" name="status[{{$data->id}}]"/></td>
								@endif
										<td>
											<select class="form-select" name="applicable[{{$data->id}}]">
											  <option value="1" selected>Yes</option>
											  <option value="0">No</option>
											</select>
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
				</div>	
			@endforeach
		    <button type="submit" class="btn btn-primary">Save
		</form>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="POST" action="{{route('temp.store2')}}">
			@csrf
			<input type="hidden" name="acr_id" value='{{$data->id}}'>
			<p class="text-danger">Update to Acr Table Quarry to be build</p>
			<div class="form-group">
			  <label for="good_work" class="fw-bold h4">
			  	2- Exceptionally good works done, if any, apart from routine duties during the period of appraisal (Max. 100 Words)
			  </label>
			  <textarea class="form-control rounded-0" id="good_work"  name="good_work" rows="5"></textarea>
			  <label for="difficultie" class="fw-bold h4">
			  	3- Difficulties faced in performing the assigned 'Tasks/Duties' (Max. 100 Words)
			  </label>
			  <textarea class="form-control rounded-0" id="difficultie"  name="difficultie" rows="5"></textarea>
			</div>

		<div class="form-group mt-2">
	        <button type="submit" class="btn btn-primary " >Save
	    </div>
		</form>
	</div>
	<div class="card-body">
		<div class="form-control">
		<form class="form-horizontal" method="POST" action="{{route('temp.store3')}}">
		    @csrf
					<input type="hidden" name="acr_id" value='{{$acr->id}}'/>
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
								<input type="hidden" name="acr_master_parameter_id[]" value='{{$data->id}}'>
								<p class="fw-bold h5 text-info">
									4.{{$slno}}- {!!$data->description!!}
									<span class="float-end small">maximum deduction - {{$data->max_marks}}</span>
								</p>
								<p class="fw-semibold text-primary ">{{$groupData['head_note']}}</p>
									<table class="table table-bordered border-primary">
										<thead class="table-light fw-bold border-primary">
											<tr class="text-center align-middle">
												@foreach($groupData['columns'] as $key=>$values)
													<td>{{$values['text']}}</td>
												@endforeach
											</tr>
										</thead>
										<tbody>
											@php
												$n = 0;
											@endphp
											@while( $n < $groupData['rows'] )
												@php  $n = $n+1; @endphp
												<tr>
													@foreach($groupData['columns'] as $key=>$values)
														<td>
															@if ($values['input_type'])
																<input 	class="form-control" 
																		type="{{$values['input_type']}}" 
																		name="{{$data->id}}[{{$n}}][{{$values['input_name']}}]"
																/>
															@else
																{{$n}}
															@endif
														</td>
													@endforeach
												</tr>
											@endwhile
										</tbody>
									</table>
								<p class="fw-semibold text-muted">{{$groupData['foot_note']}}</p>
								<hr>
								@endforeach
							@else
								@php
									$slno = $slno+1;
								@endphp
								<p class="fw-bold h5 text-info">4.{{$slno}}-  {!!config('acr.group')[$groupId]['head']!!}</p>
								<table class="table table-bordered border-primary">
									<thead class="table-light fw-bold border-primary">
										<tr class="text-center align-middle">
											<td width="auto">Sl No.</td>
											<td width="auto">Description</td>
											<td width="50%">Action Taken</td>
											<td width="auto" class="text-info">max. deduction</td>
										</tr>
									</thead>
									<tbody>
									@foreach($datas as $data)
									<input type="hidden" name="acr_master_parameter_id[]" value='{{$data->id}}'>
										<tr>
											<td>
												{{$loop->iteration}}
											</td>
											<td>
												{{$data->description}}
											</td>
											<td>
												<input 	class="form-control" 
														type="text" 
														name="{{$data->id}}[1][col_1]"
												/>
												{{-- <textarea 	class="form-control" 
														rows="2"
														name="{{$data->id}}[1]['col_1']"
												></textarea> --}}
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
				    <button type="submit" class="btn btn-primary">Save
		</form>
		</div>
	</div>
	{{-- <div class="card-body">
		<div class="form-control">
		<form class="form-horizontal" method="POST" action="{{route('temp.store3')}}">
		    @csrf
					<input type="hidden" name="acr_id" value='{{$acr->id}}'/>
					@foreach($negative_groups as $groupId => $datas)
						@php
							$groupData = config('acr.group')[$groupId];
						@endphp
						<input type="hidden" name="acr_master_parameter_id[]" value='{{$datas[0]->id}}'>
						<p class="fw-bold h5">
							4.{{$loop->iteration}}- {!!$groupData['head']!!}
							<span class="float-end small">maximum deduction - {{$datas[0]->max_marks}}</span>
						</p>
						<p class="fw-semibold text-primary ">{{$groupData['head_note']}}</p>
							<table class="table table-bordered">
								<thead>
									<tr class="text-center align-middle">
										@foreach($groupData['columns'] as $key=>$values)
											<td>{{$values['text']}}</td>
										@endforeach
									</tr>
								</thead>
								<tbody>
									<tr>
										@foreach($groupData['columns'] as $key=>$values)
											<td>
												<input 	class="form-control" 
														type="{{$values['input_type']}}" 
														name="{{$values['input_name']}}[{{$datas[0]->id}}]"
												/>
											</td>
										@endforeach
									</tr>
								</tbody>
							</table>
						<p class="fw-semibold text-muted">{{$groupData['foot_note']}}</p>
						@if(!$loop->last) <hr> @endif
					@endforeach
				    <button type="submit" class="btn btn-primary">Save
		</form>
		</div>
	</div> --}}
	{{-- @if($training)
	<div class="card-body">
		<div class="form-control">
		<form class="form-horizontal" method="POST" action="{{route('temp.store4')}}">
			@csrf
			<input type="hidden" name="acr_id" value='{{$acr->id}}'/>
			<input type="hidden" name="acr_master_parameter_id" value='{{$training->id}}'>
			@php
				$n = 0;
			@endphp
			<p class="fw-bold h5">
				4.Training Program
				<span class="float-end small">maximum deduction - {{$training->max_marks}}</span>
			</p>
			<table class="table table-bordered border-info">
				<thead>
					<tr class="text-center">
						<th>Sl.No</th>
						<th>Name of Training Program</th>
						<th>Nominated Man-Days</th>
						<th>Attended Man-Days</th>							
						<th>Date of Submission of training reports & copy of Certificate given after Successful training</th>
					</tr>
				</thead>
				<tbody>
				@while( $n < $numberOfRows )
					@php  $n = $n+1; @endphp
					<tr>
						<td>{{$n}}</td>
						<td>
							<input 	class="form-control"  type="text"  name="description[{{$n}}]" />
						</td>
						<td>
							<input 	class="form-control"  type="number"  name="nominated_days[{{$n}}]" />
						</td>
						<td>
							<input 	class="form-control"  type="number"  name="attended_days[{{$n}}]" />
						</td>
						<td>
							<input 	class="form-control"  type="text"  name="remark[{{$n}}]" />
						</td>
					</tr>
				@endwhile
				</tbody>
			</table>
			<button type="submit" class="btn btn-primary">Save
		</form>
		</div>
	</div>
	@endif --}}

</div>
@endsection