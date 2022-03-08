@extends('layouts.type200.main')
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection
@section('pagetitle')
Part -II Self-Appraisal <small>Page -3 Deduction Parameters</small>
@endsection
@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
['label'=> 'My Acrs', 'route'=>'acr.myacrs' ,'active'=>false],
['label'=> 'Deduction Parameters','active'=>true]
]])

@endsection

@section('content')
<div class="mb-3">
		@include('employee.acr.form._formHeader',['acr'=>$acr])
</div>
<div class="card border border-2 shadow-lg p-0 mb-5 bg-body rounded">
	<div class="card-body">
		@include('employee.acr.form._goBackIcon')
		<p class="fw-semibold fs-5">निम्न मापदण्डो पर भारी गई सूचना के आधार पर Reporting अधिकारी तथा Review अधिकारी
			द्वारा Negative Marks का निर्धारण करके PAR में अंकित किया जायेगा। जिन्हे Part-1 के आधार पर आकलित मार्क्स से
			घटाया जाएगा</p>
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
					<input type="hidden" name="acr_id" value='{{$acr->id}}' />
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
									@php $n = $n+1; @endphp
									<tr style="background-color:#F0FFF0;">
										@foreach($groupData['columns'] as $key=>$values)
											<td>
												@if ($values['input_type'])
												<input class="form-control" type="{{$values['input_type']}}"
													name="{{$data->id}}[{{$n}}][{{$values['input_name']}}]"
													value="{{$filled_data[$values['input_name']]}}" />
												@else
												{{$filled_data->row_no}}
												@endif
											</td>
										@endforeach
										<td>
											<button type="submit" id="{{$data->id}}" class="btn btn-outline-primary">Update</button>
										</td>
									</tr>
								@endforeach
								@php $n = $n+1; @endphp
								<tr>
									@foreach($groupData['columns'] as $key=>$values)
										<td>
											@if ($values['input_type'])
											<input class="form-control" type="{{$values['input_type']}}"
												name="{{$data->id}}[{{$n}}][{{$values['input_name']}}]" />
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
											<input class="form-control" type="{{$values['input_type']}}"
												name="{{$data->id}}[1][{{$values['input_name']}}]"
												value="{{$data->user_filled_data[0][$values['input_name']]??''}}" />
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
					<input type="hidden" id="final" name="final" value="0" />
				</form>
			</div>
			@endforeach
		@else
			<div class="card-body form-control">
				<form class="form-horizontal" id="{{$groupId}}" method="POST" action="{{route('acr.form.store3')}}">
					@csrf
					<input type="hidden" name="acr_id" value='{{$acr->id}}' />
					@php $slno = $slno+1; @endphp
					<p class="fw-bold h5 text-info">4.{{$slno}}- {!!config('acr.group')[$groupId]['head']!!}</p>
					<table class="table table-bordered border-primary">
						<thead class="table-info fw-bold border-primary">
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
								@foreach(config('acr.group')[$groupId]['columns'] as $column)
									<td>
										<input 	class="form-control" 
											type="{{$column['input_type']}}"
											name="{{$data->id}}[1][{{$column['input_name']}}]"
											@if($data->user_filled_data)
											value = "{{$data->user_filled_data[0][$column['input_name']]}}"
											@endif
										/>
									</td>
								@endforeach
								<td class="text-center align-middle text-info">
									{{$data->max_marks}}
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					<div class="text-end">
						<input type="hidden" id="final" name="final"  value="1" />
						<button type="submit" id="{{$groupId}}" class="btn btn-outline-primary">
							Save
						</button>
					</div>
				</form>
			</div>
		@endif
	@endforeach
	<p class="fw-semibold text-success ms-3">Please Save Each Line before Continue</p>
	<div class="d-flex justify-content-between mx-3 my-2">
		<a  class="btn btn-primary" href="{{ url()->previous() }}"> Back </a>
		<a  class="btn btn-primary" href="{{ route('acr.form.addTrainningToEmployee',['acr' => $acr->id])}}"> Continue </a>
	</div>
</div>
@endsection