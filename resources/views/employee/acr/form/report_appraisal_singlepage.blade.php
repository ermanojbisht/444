@extends('layouts.type200.main')
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection
@section('pagetitle')
Part -III Appraisal <small>(By Reporting Officer)</small>
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
['label'=> 'Inbox','route'=>
'acr.others.index', 'active'=>false],
['label'=> 'Appraisal By Reporting Officer','active'=>true]
]])

@endsection

@section('content')

<div class="card">
	<div class="card-body text-muted">
		<p class="fw-bold h5">
		  	किए गए कार्यों का विवरण (अधिकतम 300 शब्दों मे)
		</p>
		<p>
			{{$acr->good_work??' ----  '}}
		</p>
	</div>
	<form class="form-horizontal" method="POST" action="{{route('acr.form.storeAcrWithoutProcess')}}">
		@csrf
		<input type="hidden" name="acr_id" value='{{$acr->id}}'>
		<div class="card-body">
			<div class="form-group">
				<p class="fw-semibold h5">
					टिप्पणी
				</p>
				<textarea class="form-control rounded-3" id="appraisal_note_1" name="appraisal_note_1">{{$acr->appraisal_note_1??''}}</textarea>

			</div>

			<div class="row g-3 align-items-center mt-3">
			  <div class="col-auto">
			    <label for="report_no" class="col-form-label">Marks : </label>
			  </div>
			  <div class="col-auto">
			    <input type="number" id="report_no" name="report_no" class="form-control" value="{{$acr->report_no??0}}" step="0.01" min="0" max="100">
			  </div>
			  <div class="col-auto text-end">
			    <button type="submit" class="btn btn-primary">Save</button>
			  </div>
			</div>
		</div>
	</form>
	<div class="p-2">
		<p class="mt-3">Reference Table for Grading :</p>
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
