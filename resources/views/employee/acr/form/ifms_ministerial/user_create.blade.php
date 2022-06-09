@extends('layouts.type200.main')
@section('sidebarmenu')
	@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection
@section('pagetitle')
	Part -II Self-Appraisal
@endsection
@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
	['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
	['label'=> 'My Acrs', 'route'=>'acr.myacrs' ,'active'=>false],
	['label'=> 'Assessment of Performance','active'=>true]
	]])
@endsection

@section('content')
	{{-- @include('employee.acr.form._formHeader',['acr'=>$acr]) --}}
	<div class="card">
		<div class="card-body">
			<form class="form-horizontal" method="POST" action="{{route('acr.form.storeIfmsAcr')}}">
				@csrf
				<input type="hidden" name="acr_id" value='{{$acr->id}}'>
				<input type="hidden" name="acr_master_parameter_id" value=0>
				<p class="fw-semibold">आलोच्य अवधि मे आवंटित उत्तरदायित्व व प्राप्त उपलब्धि/ कार्यों का संक्षिप्त विवरण</p>
				<table class="table table-bordered border-primary">
						<thead class="table-info fw-bold border-primary">
							<tr class="text-center align-middle">
								<th>क्रमांक</th>
								<th>समयावधि</th>
								<th>आवंटित उत्तरदायित्व</th>
								<th>अवधि के दोरान प्राप्त उपलब्धि/ कार्य का विवरण <br><small>(अधिकतम 100 शब्द)</small></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@php $n = 0; @endphp
								@foreach($filled_data as $data)
									@php $n = $n+1; @endphp
									<tr style="background-color:#F0FFF0;">
										<td >
											{{$data->row_no}}
											<input type="hidden" name="data[{{$data->row_no}}][row_no]" value='{{$data->row_no}}'>
										</td>
										<td >
											<input class="form-control" type="text" name="data[{{$data->row_no}}][col_1]" value="{{$data->col_1}}" />
										</td>
										<td>
											<textarea class="form-control"  type="text" name="data[{{$data->row_no}}][col_2]">{{$data->col_2}}</textarea>
										</td>
										<td>
											<textarea class="form-control"  type="text" name="data[{{$data->row_no}}][col_3]">{{$data->col_3}}</textarea>
										</td>
									<td>
										<button type="submit" id="{{$acr->id}}" class="btn btn-outline-primary">Update</button>
									</td>
									</tr>
								@endforeach
								@php $n = $n+1; @endphp
								<tr>
									<td>{{$n}}</td>
									<input type="hidden" name="data[{{$n}}][row_no]" value='{{$n}}'>
									<td>
										<input class="form-control" 
											type="text"
											name="data[{{$n}}][col_1]"
										/>
									</td>
									<td>
										<textarea class="form-control"  type="text" name="data[{{$n}}][col_2]"></textarea>
									</td>
									<td>
										<textarea class="form-control"  type="text" name="data[{{$n}}][col_3]"></textarea>
									</td>
									<td>
										<button type="submit" id="{{$acr->id}}" class="btn btn-outline-primary">Save</button>
									</td>
								</tr>
							
						</tbody>
					</table>
			</form>
		</div>
	</div>
@endsection