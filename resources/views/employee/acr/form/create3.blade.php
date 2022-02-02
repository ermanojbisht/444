@extends('layouts.type200.main')
@section('content')
{{$acr->type->description}}
<hr>
<div class="card">
	@php
		$slno = 0;
	@endphp
	@foreach($negative_groups as $groupId => $datas)
		@if($groupId < 3000)
			@foreach($datas as $data)
			<div class="card-body form-control">
				<form class="form-horizontal" id="{{$data->id}}" method="POST" action="{{route('acr.form.store3')}}">
				    @csrf
					<input type="hidden" name="acr_id" value='{{$acr->id}}'/>
					<input type="hidden" name="acr_master_parameter_id[]" value='{{$data->id}}'>
					@php
						$groupData = config('acr.group')[$groupId];
						$slno = $slno+1;
					@endphp
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
							@if($groupData['multi_rows'])
								@php $n = 0; @endphp
								@foreach($data->user_filled_data as $filled_data)
									@php  $n = $n+1; @endphp
									<tr>
										@foreach($groupData['columns'] as $key=>$values)
											<td>
												@if ($values['input_type'])
													{{$filled_data[$values['input_name']]}}
												@else
													{{$filled_data->row_no}}
												@endif
											</td>
										@endforeach
									<tr>
								@endforeach
									@php  $n = $n+1; @endphp
									<tr style="background-color:yellow;">
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
							@else
								{{-- @php $n = 0; @endphp
								@foreach($data->user_filled_data as $filled_data)
									@php  $n = $n+1; @endphp --}}
									<tr style="background-color:yellow;">
										@foreach($groupData['columns'] as $key=>$values)
											<td>
												@if ($values['input_type'])
													<input 	class="form-control" 
															type="{{$values['input_type']}}" 
															name="{{$data->id}}[1][{{$values['input_name']}}]"
															value="{{$data->user_filled_data[0][$values['input_name']]??''}}" 
													/>
												@else
													{{-- {{$n}} --}}
												@endif
											</td>
										@endforeach
									</tr>
								{{-- @endforeach --}}
							@endif
									<tr style="background-color:yellow;">
										<td colspan="{{count($groupData['columns'])}}" class="text-end">
											<button type="submit" id="{{$data->id}}" class="btn btn-outline-primary">Save 4.{{$slno}} Details</button>
										</td>
									</tr>
						</tbody>
					</table>
					<p class="fw-semibold text-muted">{{$groupData['foot_note']}}</p>
				</form>
			</div>
			@endforeach
		@else
			<div class="card-body form-control">
				<form class="form-horizontal" id="{{$groupId}}" method="POST" action="{{route('acr.form.store3')}}">
				    @csrf
					<input type="hidden" name="acr_id" value='{{$acr->id}}'/>
					@php $slno = $slno+1; @endphp
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
					<div class="text-end">
						<button type="submit" id="{{$groupId}}" class="btn btn-outline-primary">Save 4.{{$slno}} Details</button>
					</div>
				</form>
			</div>
		@endif
	@endforeach
</div>
@endsection