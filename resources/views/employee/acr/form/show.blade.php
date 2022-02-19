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
									<tr
										@if($data->applicable == 0) class="bg-light" @endif
									>
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
												<span class="text-danger">No</span>
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
			@if($acr->is_single_page)
				<p class="fw-semibold h5">
					किए गए कार्यों का विवरण (अधिकतम 300 शब्दों मे)
				</p>
				<p class="text-info border-primary" style="min-height: 150px;">
					{{$acr->good_work??'--no data filled--'}}
				</p>
			@else
				<p class="fw-semibold h5">
					2- Exceptionally good works done, if any, apart from routine duties during the period of appraisal
				</p>
				<p class="text-info border border-light p-3" style="min-height: 150px;">
					{{$acr->good_work??'--no data filled--'}}
				</p>
				<p class="fw-semibold h5">
					3- Difficulties faced in performing the assigned 'Tasks/Duties'
				</p>
				<p class="text-info border border-light p-3" style="min-height: 150px;">
					{{$acr->difficultie??'--no data filled--'}}
				</p>

			@endif
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
								</tr>
							</thead>
							<tbody>
								@if($groupData['multi_rows'])
									@php $n = 0; @endphp
									@forelse($data->user_filled_data as $filled_data)
										@php  $n = $n+1; @endphp
										<tr>
											@foreach($groupData['columns'] as $key=>$values)
												<td>
													@if ($values['input_type'])
														{{$filled_data[$values['input_name']]??'--'}}
													@else
														{{$filled_data->row_no}}
													@endif
												</td>
											@endforeach
										<tr>
									@empty	
										<tr class="text-center">
											@foreach($groupData['columns'] as $key=>$values)
												<td> -- </td>
											@endforeach
										</tr>	
									@endforelse
								@else
									<tr>
									@forelse($groupData['columns'] as $key=>$values)
										<td>
											@if ($values['input_type'])
													{{$data->user_filled_data[0][$values['input_name']]??'--'}}
											@endif
										</td>
									@empty	
										<td class="text-center"> -- </td>
									@endforelse
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
								@foreach(config('acr.group')[$groupId]['columns'] as $column)
									<th width="auto">{{$column['text']}}</th>
								@endforeach
								<th width="auto" class="text-info">max. deduction</th>
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
									@foreach(config('acr.group')[$groupId]['columns'] as $column)
										<td>
											{{$data->user_filled_data[0][$column['input_name']]??'--'}}
										</td>
									@endforeach
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
            <P class="fw-semibold h5 ">
                5. Training Details
            </P>
			<table class="table table-sm">
				<thead>
				<tr>
					<th width="10%" class="text-center">Sl No.</th>
					<th>Topic </th>
					<th>Training Name</th>
				</tr>
				</thead>
				<tbody>
					@php $n=0 @endphp
					@forelse($master_trainings as $key=>$trainings)
						@foreach($trainings as $training)
							@php $n=$n+1 @endphp
							<tr>
								<td class="text-center">{{$n}}</td>
								<td>{{$key}}</td>
								<td>{{$training->description}}</td>
							</tr>
						@endforeach
					@empty
					@endforelse
				</tbody>

			</table>
		</div>
		<div>
			<div class="float-end p-3 text-center fw-semibold">
				<span class="pb-0">({{$acr->employee->name}})</span>
				<br>
				<span class="pt-0">Submitted on :{{$acr->submitted_at->format('d M Y')}}</span>
				
			</div>
			
		</div>
	</div>
@endsection
