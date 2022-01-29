@extends('layouts.type200.main')
@section('content')
{{$acr->type->description}}
<hr>
<div class="card">
	<form class="form-horizontal" method="POST" action="{{route('temp.store')}}">
	    @csrf
			
				<input type="hidden" name="acr_id" value='{{$acr->id}}'/>	
				@foreach($dataGroups as $group => $datas)
					<div>
						<p class="fw-bold h4">{!!config('acr.group')[$group]['head']!!}</p>
						<p class="fw-bold h6">{{config('acr.group')[$group]['head_note']}}</p>
						<p class="fw-bold h6">{{config('acr.group')[$group]['foot_note']}}</p>
					</div>	
					<div class="form-control">
						@php
							$table_type = config('acr.group')[$group]['table_type'];
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
			    <div class="form-group mt-2">
			        <button type="submit" class="btn btn-primary " >Save
			    </div>
	</form>
</div>
<div class="card">
	<form class="form-horizontal" method="POST" action="{{route('temp.store2')}}">
		@csrf
		<input type="hidden" name="acr_id" value='{{$data->id}}'>
		<div class="form-group">
		  <label for="good_work" class="fw-bold h4">
		  	2- Exceptionally good works done, if any, apart from routine duties during the period of appraisal (Max. 100 Words)
		  </label>
		  <textarea class="form-control rounded-0" id="good_work"  name="good_work" rows="10"></textarea>
		  <label for="difficultie" class="fw-bold h4">
		  	3- Difficulties faced in performing the assigned 'Tasks/Duties' (Max. 100 Words)
		  </label>
		  <textarea class="form-control rounded-0" id="difficultie"  name="difficultie" rows="10"></textarea>
		</div>

	<div class="form-group mt-2">
        <button type="submit" class="btn btn-primary " >Save
    </div>
	</form>
</div>
<div class="card">
	<form class="form-horizontal" method="POST" action="{{route('temp.store')}}">
	    @csrf
				<input type="hidden" name="acr_id" value='{{$acr->id}}'/>	
				@foreach($NegativeGroups as $group => $datas)
					<div>
						<p class="fw-bold h4">{!!config('acr.group')[$group]['head']!!}</p>
						<p class="fw-bold h6">{{config('acr.group')[$group]['head_note']}}</p>
						<p class="fw-bold h6">{{config('acr.group')[$group]['foot_note']}}</p>
					</div>	
					<div class="form-control">
						@php
							$table_type = config('acr.group')[$group]['table_type'];
						@endphp
							<table class="table">
								<thead>
									<tr>
										@foreach(config('acr.group')[$group]['columns'] as $key=>$values)
											<td> {{config('acr.group')[$group]['columns'][$key]['text']}}</td>
										@endforeach
									</tr>
								</thead>
								<tbody>
									<tr>
										@foreach(config('acr.group')[$group]['columns'] as $key=>$values)
											<td> </td>
										@endforeach
									</tr>
								</tbody>
							</table>
					</div>	
				@endforeach
			    <div class="form-group mt-2">
			        <button type="submit" class="btn btn-primary " >Save
			    </div>
	</form>
</div>
@endsection