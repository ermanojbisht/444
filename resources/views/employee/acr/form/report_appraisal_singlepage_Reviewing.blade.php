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
		  	स्वयं द्वारा किए गए कार्यों के संबंध मे विवरण व स्वयं का विश्लेषण (अधिकतम 300 शब्दों मे)
		</p>
		<p class="text-info border border-primary p-3" style="min-height: 150px;">
			{{$acr->good_work??' ----  '}}
		</p>
	</div>
	<div class="card-body text-muted">
		<p class="fw-semibold h5">
			प्रतिवेदक अधिकारी की अभियुक्ति 
		</p>
		<p class="small px-3 py-0">(क) अभिव्यक्त करें की योग्यता , (ख) सहयोगियों से संबंध, (ग) बौद्धिक स्तर, (घ) श्रमशीलता एवं जागरूकता, (ड़) कर्तव्य निर्वहन के प्रति लग्न, (च) अन्य टिप्पणी</p>
		<p class="text-info border border-primary p-3" style="min-height: 150px;">
			{{$acr->appraisal_note_1??' ---- '}}
		</p>
		<p class="fw-bold h5">
		  	प्रतिवेदक अधिकारी द्वारा दिए गए अंक - {{$acr->report_no??' --??-- '}}
		</p>

		<div class="pt-3">
			<p> प्रतिवेदक अधिकारी  : {{$acr->reportUser()->name}} </p>
			<p> on : {{$acr->report_on->format('d M Y')}}</p>

		</div>
	</div>

	<form class="form-horizontal" method="POST" action="{{route('acr.form.storeAcrWithoutProcessReview')}}">
		@csrf
		<input type="hidden" name="acr_id" value='{{$acr->id}}'>
		<div class="card-body">
			<div class="form-group">
				<p class="fw-semibold h5">
				समीक्षक अधिकारी की अभियुक्ति 
				</p>
				<textarea class="form-control rounded-3" id="review_remark" rows="5" name="review_remark">{{$acr->review_remark??''}}</textarea>

			</div>

			<div class="row g-3 align-items-center mt-3">
			  <div class="col-auto">
			    <label for="review_no" class="col-form-label">Marks : </label>
			  </div>
			  <div class="col-auto">
			    <input type="number" id="review_no" name="review_no" class="form-control" value="{{$acr->review_no??0}}" step="0.01" min="0" max="100">
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
