@extends('layouts.type200.main')
@section('sidebarmenu')
	@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection
@section('pagetitle')
	Part -II Self-Appraisal <small>Page -1 Assessment of Performance</small>
@endsection
@section('content')
	@if(!$view)
		@include('employee.acr.form._formHeader',['acr'=>$acr])
	@endif
	<div class="card">
		<div class="card-body form-control">
			<form class="form-horizontal" method="POST" action="{{route('acr.form.store1')}}">
			    @csrf
				<input type="hidden" name="acr_id" value='{{$acr->id}}'/>	
				@foreach($data_groups as $groupId => $datas)
					@php
						$groupData = config('acr.group')[$groupId];
					@endphp
					<div>
						<p class="fw-bold h5">{!!$groupData['head']!!}</p>
						<p class="fw-semibold h5">{{$groupData['head_note']}}</p>
						@if(!$view)
							<p class="text-danger">*Please Ensure to Select NO on Dropdown for Parameters Not Applicable</p>
						@endif
						<p class="fw-bold h6">{{$groupData['foot_note']}}</p>
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
									<input type="hidden" name="acr_master_parameter_id[]" value='{{$data->id}}'>
									<tr>
										<td>{{$loop->iteration}}</td>
										<td>{{$data->description}}</td>
										<td class="text-center">{{$data->max_marks}}</td>
										@if($table_type == 1)
											<td class="text-center">{{$data->unit}}</td>
											
											<td class="text-end">
												@if(!$view)
													<input class="form-control text-end" type="text" name="target[{{$data->id}}]" 
														@if(!empty($data->user_target))
															style="background-color:#F0FFF0;"
															value="{{$data->user_target}}"
														@endif
													/>
												@else
													{{$data->user_target??''}}
												@endif
											</td>
											<td class="text-end">
												@if(!$view)
													<input class="form-control text-end" type="text" name="achivement[{{$data->id}}]" 
														@if(!empty($data->user_achivement))
															style="background-color:#F0FFF0;"
															value="{{$data->user_achivement}}"
														@endif
													/>
												@else
													{{$data->user_achivement??''}}
												@endif
											</td>
											<input type="hidden" name="status[{{$data->id}}]" value="" />
										@endif
										@if($table_type == 2)
											<td class="text-end">
												@if(!$view)
													<input class="form-control" type="text" name="status[{{$data->id}}]" value="{{$data->status}}" 
													@if(!empty($data->status))
														style="background-color:#F0FFF0;"
													@endif
													/>
												@else
													{{$data->status??''}}
												@endif
											</td>
												<input type="hidden" name="target[{{$data->id}}]" value="" />
												<input type="hidden" name="achivement[{{$data->id}}]" value="" />
										@endif
										<td class="text-center">
											@if(!$view)
												<select class="form-select" name="applicable[{{$data->id}}]">
												  <option value="1" 
												  	@if($data->applicable != 0)
												  		selected
												  	@endif
												  	>Yes</option>
												  <option value="0"
												  	@if($data->applicable === 0)
												  		selected
												  	@endif
												  	>No</option>
												</select>
											@else
												@if($data->applicable != 0)
													Yes
												@else
													No
												@endif
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
				@if(!$view)
					<div class="text-end">
				    	<button type="submit" class="btn btn-primary">Save
					</div>
				@endif
			</form>
		</div>
	</div>
@endsection