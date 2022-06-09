@extends('layouts.type200.main')
@section('sidebarmenu')
	@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection
@section('pagetitle')
	Part -III Appraisal By Reporting Officer
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
			
		<p class="text-info text-center fw-semibold h5">Part -II Self Appraisal Filled By Employee</p>
			<p class="fw-semibold text-info">आलोच्य अवधि मे आवंटित उत्तरदायित्व व प्राप्त उपलब्धि/ कार्यों का संक्षिप्त विवरण</p>
			<table class="table table-bordered border-info">
				<thead class="fw-bold border-info text">
					<tr class="text-center align-middle">
						<th class="text-info">क्रमांक</th>
						<th class="text-info">समयावधि</th>
						<th class="text-info">आवंटित उत्तरदायित्व</th>
						<th class="text-info">अवधि के दोरान प्राप्त उपलब्धि/ कार्य का विवरण</th>
					</tr>
				</thead>
				<tbody>
						@foreach($filled_data as $data)
							<tr>
								<td class="text-info">{{$data->row_no}}</td>
								<td class="text-info">{{$data->col_1}}</td>
								<td class="text-info">{{$data->col_2}}</td>
								<td class="text-info">{{$data->col_3}}</td>
							</tr>
						@endforeach
				</tbody>
			</table>
			<hr>
			<p class="text-info text-center fw-semibold h5">Part -III Appraisal By Reviewing Officer</p>
			<p class="fw-semibold ">1- व्यक्तिगत गुणों का मूल्यांकन</p>
			<form class="form-horizontal" method="POST" action="{{route('acr.form.storeIfmsReporting')}}">
				@csrf
				<input type="hidden" name="acr_id" value='{{$acr->id}}'>
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>व्यक्तिगत गुण</th>
							<th>अधिकतम अंक</th>
							<th>अंक</th>
							<th>टिप्पणी</th>
						</tr>	
					</thead>
					<tbody>
						@foreach($acr_master_parameter->where('config_group',4001) as $parameter)
						<tr>
							<td>{{$loop->index + 1}}</td>
							<td>{{$parameter->description}}</td>
							<td>{{$parameter->max_marks}}</td>
							<td>
								<input class="form-control text-end" type="number"  step="0.01" min="0.0" max="{{$parameter->max_marks}}" name="data[{{$parameter->id}}][no]" required />
							</td>
							<td>
								<input class="form-control"  type="text" name="data[{{$parameter->id}}][remark]" required/>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<br>
				<p class="fw-semibold ">2- किए गए कार्यों का मूल्यांकन</p>
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>मदें</th>
							<th>अधिकतम अंक</th>
							<th>अंक</th>
							<th>टिप्पणी</th>
						</tr>	
					</thead>
					<tbody>
						@foreach($acr_master_parameter->where('config_group',4002) as $parameter)
						<tr>
							<td>{{$loop->index + 1}}</td>
							<td>{{$parameter->description}}</td>
							<td>{{$parameter->max_marks}}</td>
							<td>
								<input class="form-control text-end" type="number"  step="0.01" min="0.0" max="{{$parameter->max_marks}}" name="data[{{$parameter->id}}][no]" required />
							</td>
							<td>
								<input class="form-control"  type="text" name="data[{{$parameter->id}}][remark]" required/>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<br>
				<p class="fw-semibold ">3- प्रतिवेदक अधिकारी की टिप्पणी <small>(अधिकतम 100 शब्द)</small></p>
				<textarea class="form-control" name="reporting_remark" required></textarea>
				<br>
				<div class="text-end">
					<button type="submit" id="{{$acr->id}}" class="btn btn-outline-primary">Save</button>
				</div>
			</form>
			<p>Reference Table for Grading :</p>
				<table class="table table-bordered table-sm">
					<tr class="text-center">
						<td>Grading</td>
						<td>Outstanding</td>
						<td>Very Good</td>
						<td>Good</td>
						<td>Satisfactory</td>
						<td>Unsatisfactory</td>
					</tr>
					<tr class="text-center">
						<td>Marks</td>
						<td>>80</td>
						<td>>60 upto 80</td>
						<td>>40 upto 60</td>
						<td>>20 upto 40</td>
						<td>upto 20 </td>
					</tr>
				</table>
		</div>
	</div>
@endsection