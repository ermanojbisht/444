@extends('layouts.type200.main')
@section('sidebarmenu')
	@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection
@section('pagetitle')
	Part -IV Appraisal By Reviewing Officer
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
		<div class="card-body text-info">
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
			<p class="text-center fw-semibold h5">Part -III Appraisal</p>
			<p class="text-center fw-semibold ">प्रतिवेदक अधिकारी की अभ्युक्ति</p>
			<p class="fw-semibold ">1- व्यक्तिगत गुणों का मूल्यांकन</p>
			<table class="table table-sm">
					<thead>
						<tr>
							<th class="text-info">#</th>
							<th class="text-info">व्यक्तिगत गुण</th>
							<th class="text-info">अधिकतम अंक</th>
							<th class="text-info">अंक</th>
							<th class="text-info">टिप्पणी</th>
						</tr>	
					</thead>
					<tbody>
						@foreach($acr_master_parameter->where('config_group',4001) as $parameter)
						<tr>
							<td class="text-info">{{$loop->index + 1}}</td>
							<td class="text-info">{{$parameter->description}}</td>
							<td class="text-info">{{$parameter->max_marks}}</td>
							<td class="text-info">
								{{$acr_filled_parameter->where('acr_master_parameter_id',$parameter->id)->first()->reporting_marks}}
							</td>
							<td class="text-info">
								{{$acr_filled_parameter->where('acr_master_parameter_id',$parameter->id)->first()->status}}
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<br>
				<p class="fw-semibold mt-0">2- किए गए कार्यों का मूल्यांकन</p>
				<table class="table table-sm">
					<thead>
						<tr>
							<th class="text-info">#</th>
							<th class="text-info">मदें</th>
							<th class="text-info">अधिकतम अंक</th>
							<th class="text-info">अंक</th>
							<th class="text-info">टिप्पणी</th>
						</tr>	
					</thead>
					<tbody>
						@foreach($acr_master_parameter->where('config_group',4002) as $parameter)
						<tr>
							<td class="text-info">{{$loop->index + 1}}</td>
							<td class="text-info">{{$parameter->description}}</td>
							<td class="text-info">{{$parameter->max_marks}}</td>
							<td class="text-info">
								{{$acr_filled_parameter->where('acr_master_parameter_id',$parameter->id)->first()->reporting_marks}}
							</td>
							<td class="text-info">
								{{$acr_filled_parameter->where('acr_master_parameter_id',$parameter->id)->first()->status}}
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<br>
				<p class="fw-semibold ">3- प्रतिवेदक अधिकारी की टिप्पणी <small>(अधिकतम 100 शब्द)</small></p>
				<p class="border border-info p-2 m-2">{{$acr->appraisal_note_1}}</p>

				<p class="fw-semibold ">4- समग्र ग्रेड <span class="fw-semibold text-info h4">{{$acr->report_no}}</span></p>

				<p class="fw-semibold text-end m-0">by  <span>{{$acr->userOnBasisOfDuty('report')->name}}</span></p>
				<p class="fw-semibold text-end m-0">on <span>{{$acr->report_on->format('d m Y')}}</span></p>
				<hr>
				<p class="text-center fw-semibold h5">Part -IV Review</p>
				<p class="text-center fw-semibold ">समीक्षक अधिकारी की अभ्युक्ति</p>
				<P>क्या आप प्रतिवेदक अधिकारी द्वारा किए गए मूल्यांकन से सहमत है? मत भिन्नता की स्थिति मे कारण तथा टिप्पणी भी अंकित करें</P>
				<form class="form-horizontal" method="POST" action="{{route('acr.form.storeIfmsReview')}}">
					@csrf
					<input type="hidden" name="acr_id" value='{{$acr->id}}'>
					<textarea class="form-control" name="review_remark" required></textarea>
					<div class="row g-3 align-items-center mt-3">
					  <div class="col-auto">
					    <label for="review_no" class="col-form-label">समग्र ग्रेड</label>
					  </div>
					  <div class="col-auto">
					    <input class="form-control text-end col-md-3" type="number"  step="0.01" min="0.0" name="review_no" required />
					  </div>
					  <div class="col-auto">
					      Out of 100
					  </div>
					</div>
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