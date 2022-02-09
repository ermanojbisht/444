@extends('layouts.type200.main')

@section('styles')

@endsection
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection

@section('pagetitle')
My ACR
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
['label'=> 'Inbox','route'=>
'acr.others.index', 'active'=>false],
['label'=> 'Report ACR','active'=>true]
]])

@endsection

@section('content')
<div class="card">
	<div class="card-body">

		<div class="form-group">
			<div class="row">
				<div class="col-md-4">
					<p class="fw-bold"> Name of the officer Reported Upon :- </p>
				</div>
				<div class="col-md-6">
					<p class="fw-semibold text-info"> {{$acr->employee->name }} </p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<p class="fw-bold"> Date of Birth :-</p>
				</div>
				<div class="col-md-6">
					<p class="fw-semibold text-info"> {{$acr->employee->birth_date->format('d M Y')}} </p>
				</div>
			</div>
		</div>


		<form class="form-horizontal" method="POST" action="{{route('acr.others.report.save')}}"
		onsubmit="return confirm('Above Written Details are correct to my knowledge. ( उपरोक्त दिए गए प्रपत्र एवं डाटा से में सहमत हूँ  ) ??? ');">
			@csrf
			<div class="row">
				<div class="col-md-12  ">
					<p class="fw-bold h3"> 6. Integrity Certificate : </p>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-md-12">
					<input type="radio" class="align-middle" name="integrity" checked="true" id="integrity_yes" value='true' " />
					<label for="integrity_yes" class="fw-semibold align-middle"> a. The general reputation of Sri/ Ms
						<u> _ _ _ <span id="employee_name_yes"> {{$acr->employee->name }} </span> _ _ _ </u> for honesty
						is good and I certify his / her integrity. </label>
				</div>
				<hr/>
				<div class="col-md-12">
					<input type="radio" class="align-middle" name="integrity" id="integrity_no" value='false'" />
					<label for="integrity_no" class="fw-semibold align-middle"> b. The general reputation of Sri/ Ms
						<u> _ _ _ <span id="employee_name_no"> _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ </span> _ _ _ </u> <br/>
						for honesty is not good and  I withhold his / her integrity on account of the following reasons. </label>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-12">
					<p id="lbl_reason" class="fw-bold"> In Case of difference of opinion, details may be given </p>
					<textarea type="text" id="reason" name="reason" rows="4" class="form-control" ></textarea>
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
		$('input[type=radio][name="integrity"]').change(function () {
			if($(this).attr('value') == "true")
			{
				$("#employee_name_yes").html("{{$acr->employee->name }}");
				$("#employee_name_no").html(" _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ ");
				$("#lbl_reason").removeClass('required');
				$("#reason").removeAttr('required');
				$("#reason").val('');
			}
			else
			{
				$("#employee_name_yes").html(" _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ ");
				$("#employee_name_no").html('{{$acr->employee->name }} ');

				$("#lbl_reason").addClass('required');				
				$("#reason").prop('required',true);
				$("#reason").css('background-color','antiquewhite');
				$("#reason").focus();

			}
        });
	});
</script>

@endsection