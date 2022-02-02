@extends('layouts.type200.main')
@section('content')
<div class="d-flex justify-content-between">
	<span>
		{{$acr->type->description}}
	</span>
	<span>
		<div class="btn-group" role="group" aria-label="Basic outlined example">
		  <a class="btn btn-outline-primary" href="{{route('acr.form.create1',['acr' => $acr])}}">Part-1</a>
		  <a class="btn btn-outline-primary" href="{{route('acr.form.create2',['acr' => $acr])}}">Part-2</a>
		  <a class="btn btn-outline-primary" href="{{route('acr.form.create3',['acr' => $acr])}}">Part-3</a>
		  <a class="btn btn-outline-primary" href="{{route('acr.form.create4',['acr' => $acr])}}">Part-4</a>
		</div>
	</span>
</div>
<hr>
<div class="card">
	<div class="card-header">
	4- निम्न बिन्दुओ पर उपलब्ध सूचना के आधार पर Reporting अधिकारी तथा Review अधिकारी Negative Marks का निर्धारण करके PAR में अंकित किया जायेगा ।	
	<p class="text-danger">Rows with Feded Background have data and may be edited </p>
	<p class="text-danger">Rows start with Sl No means Multi Row Table  </p>
	<p class="text-danger">Each Question have different Save Button  </p>
	</div>
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
						<thead class="table-info fw-bold border-primary">
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
													<input 	class="form-control" 
															type="{{$values['input_type']}}" 
															name="{{$data->id}}[{{$n}}][{{$values['input_name']}}]"
															value="{{$filled_data[$values['input_name']]}}"
													/>
												@else
													{{$filled_data->row_no}}
												@endif
											</td>
										@endforeach
										<td>
											<button type="submit" id="{{$data->id}}" class="btn btn-outline-primary">Save</button>
										</td>
									<tr>
								@endforeach
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
										<td>
											<button type="submit" id="{{$data->id}}" class="btn btn-outline-primary">Save</button>
										</td>
									</tr>
							@else
								@if(!empty($data->user_filled_data[0]))
									<tr style="background-color:#F0FFF0;">
								@else
									<tr>
								@endif
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
										<td>
											<button type="submit" id="{{$data->id}}" class="btn btn-outline-primary">Save</button>
										</td>
									</tr>
							@endif
						</tbody>
					</table>
					{{-- <p class="fw-semibold text-muted">{{$groupData['foot_note']}}</p> --}}
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
						<thead class="table-info fw-bold border-primary">
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
										<input 	class="form-control" 
												type="text" 
												name="{{$data->id}}[1][col_1]"
												value="{{$data->user_filled_data[0]['col_1']??''}}" 
										/>
									</td>
									<td class="text-center align-middle text-info">
										{{$data->max_marks}}
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					<div class="text-end">
						<button type="submit" id="{{$groupId}}" class="btn btn-outline-primary">
							<svg class="icon icon-lg">
					            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-save"></use>
					        </svg>
							Save
						</button>
					</div>
				</form>
			</div>
		@endif
	@endforeach
</div>
@endsection