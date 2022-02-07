@extends('layouts.type200.main')

@section('styles')

@endsection
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection

@section('pagetitle')
Part - IV ( Assessment by the Accepting Authority)
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
['label'=> 'Inbox','route'=>
'acr.others.index', 'active'=>false],
['label'=> 'Accept ACR','active'=>true]
]])

@endsection

@section('content')
<div class="card">
	<div class="card-body">
		<form class="form-horizontal" method="POST" action="{{route('acr.others.accept.save')}}"
		onsubmit="return confirm('Above Written Details are correct to my knowledge. ( उपरोक्त दिए गए प्रपत्र एवं डाटा से में सहमत हूँ  ) ??? ');">
			{{--  --}}
			@csrf

			<div class="row">
				<div class="col-md-12 text-center ">
					<p class="fw-bold h3"> Part - IV ( Assessment by the Accepting Authority) </p>
				</div>
			</div>

			<br />

			<div class="form-group">
				<div class="row">
					<div class="col-md-4">
						<p class="fw-bold h5"> Name of the officer Reported Upon :- </p>
					</div>
					<div class="col-md-6">
						<p class="fw-bold"> {{$acr->employee->name }} </p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<p class="fw-bold h5"> Date of Birth :-</p>
					</div>
					<div class="col-md-6">
						<p class="fw-bold "> {{$acr->employee->birth_date->format('d M Y')}} </p>
					</div>
				</div>
			</div>

			<br />
			<div class="row">
				<div class="col-md-6">
					<p class="fw-bold h5"> Do you agree with the remarks of the reporting/reviewing authority ? </p>
				</div>
				<div class="col-md-2">
					{!! Form::select('acr_agree', config('site.yesNo'), '1',
					['id'=>'acr_agree','class'=>'form-select'], ) !!}
				</div>
			</div>
			<br />
			<br />
			<div class="row">
				<div class="col-md-12">
					<p id="lbl_reason" class="fw-bold h5"> In Case of difference of opinion details and resaons for the
						same may be
						given </p>
				</div>
				<div class="col-md-12">
					<input type="text" id="reason" name="reason" rows="4" class="form-control" />
				</div>
			</div>
			<br />
			<br />
			<div class="row">
				<div class="col-md-6">
					<p class="fw-bold h5"> Overall Grade & Marks (On a score of 1 - 100) </p>
				</div>
				<div class="col-md-3">
					<div class="row">
						<div class="col-md-6">
							<p class="fw-bold h5"> Marks </p>
						</div>
						<div class="col-md-6">
							<input id="marks" name="marks" type="number" step="0.01" onblur="findGrades()" maxlength="3"
								class="form-control" required value="{{$acr->review_no}}" />
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-md-6">
							<p class="fw-bold h5"> Grade </p>
						</div>
						<div class="col-md-6">
							<label class="fw-bold h5" id="grades"> </label>
						</div>
					</div>
				</div>
			</div>
			<br />
			<br />
			<div class="row">
				<div class="col-md-12">
					<p class="fw-bold h5"> Reference table for Grading </p>
				</div>
				<div class="col-md-12">
					<table class="table">
						<tr>
							<th>Grading</th>
							<th>Out Standing</th>
							<th>Very Good</th>
							<th>Good</th>
							<th>Satisfactory</th>
							<th>Unsatisfactory</th>
						</tr>
						<tr>
							<th>Marks</th>
							<td> > 80.0</td>
							<td> > 60.0 upto 80.0</td>
							<td> > 40.0 upto 60.0</td>
							<td> > 20.0 upto 40.0</td>
							<td> < 20.0</td>
						</tr>
					</table>
				</div>
			</div>
			<br />

			<br />
			<div class="row">
				<div class="col-md-3">
					<input type="hidden" name="acr_id" value="{{$acr->id}}" />
					<input type="submit" class="btn btn-primary " value="Save" />
				</div>
			</div>
		</form>
	</div>


</div>


@endsection


@section('footscripts')
<script type="text/javascript">
	$(document).ready(function () { 
		$('#acr_agree').change(function (e) {
			 if($("#" + this.id).val() == 0)
			 {
				$("#lbl_reason").addClass('required');
				$("#reason").prop('required',true);
				$("#reason").css('background-color','antiquewhite');
				$("#reason").focus();
			 }else
			 {
				$("#lbl_reason").removeClass('required');
				$("#reason").removeAttr('required');
				$("#reason").removeAttr('style');
			 }
		});

		findGrades();
	});

	function findGrades()
	{
		let marks = $("#marks").val();
		if(marks < 0)
		{
			alert("Marks can't be less then Zero. ");
			$("#marks").val('');
		}			
		else if(marks > 100)
		{
			alert("Marks can't be greater then 100. ");
			$("#marks").val('');
		}
		else
		{
			switch (true)
			{
				case (marks > 80.0) :
				{
					$("#grades").html('Out Standing');
					break;
				} 
				case (marks > 60.0 &&  marks <= 80.0) :
				{
					$("#grades").html('Very Good');
					break;
				} 
				case (marks > 40.0 &&  marks <= 60.0) :
				{
					$("#grades").html('Good');
					break;
				} 
				case (marks > 20.0 &&  marks <= 40.0) :
				{
					$("#grades").html('Satisfactory');
					break;
				} 
				case (marks <= 20.0) :
				{
					$("#grades").html('Unsatisfactory');
					break;
				} 
				default : 
				{
					$("#grades").html('');
					break;
				}

			}
			
						
			}
		}	
</script>

@endsection