@extends('layouts.type200.main')
@section('sidebarmenu')
	@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection
@section('pagetitle')
	Part -II Self-Appraisal <small>Page -1 Assessment of Performance</small>
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
	['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
	['label'=> 'My Acrs', 'route'=>'acr.myacrs' ,'active'=>false],
	['label'=> 'Assessment of Performance','active'=>true]
]])

@endsection

@section('content')
	<div class="mb-3">
		@include('employee.acr.form._formHeader',['acr'=>$acr])
	</div>
	<div class="card shadow-lg p-0 mb-5 bg-body rounded border border-2">
		@include('employee.acr.form._goBackIcon')
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
						<p class="text-danger">*Please Ensure to Select NO on Dropdown for Parameters Not Applicable</p>
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
									<th>Applicable</th>
								@if($table_type == 1)
									<th>Unit</th>
									<th>Target</th>
									<th>Target Achived</th>
								@endif
								@if($table_type == 2)
									<th>Status of Progress</th>			
								@endif
									
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
										<td class="text-center">
											<select class="form-select" name="applicable[{{$data->id}}]">
											  <option value="1" class="text-success" 
											  	@if($data->applicable != 0)
											  		selected
											  	@endif
											  	>Yes</option>
											  <option value="0" class="text-danger"
											  	@if($data->applicable === 0)
											  		selected
											  	@endif
											  	>No</option>
											</select>
										</td>
										@if($table_type == 1)
											<td class="text-center">{{$data->unit}}</td>
											
											<td class="text-end">
												<input class="form-control text-end" type="number" step="0.01"
												min="0.1"
												name="target[{{$data->id}}]" 
													@if(!empty($data->user_target))
														style="background-color:#F0FFF0;"
														value="{{$data->user_target}}"
													@endif
												/>
											</td>
											<td class="text-end">
												<input class="form-control text-end" type="number"  step="0.01"
												min="0.0" name="achivement[{{$data->id}}]" 
													@if(!empty($data->user_achivement))
														style="background-color:#F0FFF0;"
														value="{{$data->user_achivement}}"
													@endif
												/>
											</td>
											<input type="hidden" name="status[{{$data->id}}]" value="" />
										@endif
										@if($table_type == 2)
											<td class="text-end">
												<input class="form-control" type="text" name="status[{{$data->id}}]" value="{{$data->status}}" 
												@if(!empty($data->status))
													style="background-color:#F0FFF0;"
												@endif
												/>
											</td>
												<input type="hidden" name="target[{{$data->id}}]" value="" />
												<input type="hidden" name="achivement[{{$data->id}}]" value="" />
										@endif
										
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
				<div class="d-flex justify-content-between">
			    	<a  class="btn btn-primary" href="{{ url()->previous() }}"> Back </a>
			    	<button type="submit" class="btn btn-primary">Save and Continue</button>
				</div>
			</form>
		</div>
	</div>
@endsection