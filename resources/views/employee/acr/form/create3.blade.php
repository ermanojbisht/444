@extends('layouts.type200.main')
@section('content')
{{$acr->type->description}}
<hr>
<div class="card">
	<div class="card-body">
		<div class="form-control">
		<form class="form-horizontal" method="POST" action="{{route('acr.form.store3')}}">
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
</div>
@endsection