@extends('layouts.type200.main')
@section('content')
{{$acr->type->description}}
<hr>
<div class="card">
	<div class="card-body">
		<form class="form-horizontal" method="POST" action="{{route('acr.form.store1')}}">
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
										<td><input class="form-control" type="text" name="target[{{$data->id}}]" value="{{$data->user_target}}"/></td>
										<td><input class="form-control" type="text" name="achivement[{{$data->id}}]" value="{{$data->user_achivement}}" /></td>
										<input type="hidden" name="status[{{$data->id}}]" value="" />
								@endif
								@if($table_type == 2)
										<td><input class="form-control" type="text" name="status[{{$data->id}}]" value="{{$data->status}}" /></td>
										<input type="hidden" name="target[{{$data->id}}]" value="" />
										<input type="hidden" name="achivement[{{$data->id}}]" value="" />
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
</div>
@endsection