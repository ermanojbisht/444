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
					<p class="fw-semibold text-info"> {{$acr->employee->shriName }} </p>
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
					<p class="fw-bold h3"> Integrity Certificate : </p>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-md-12">
					<input type="radio" class="align-middle" name="report_integrity" checked="true" id="report_integrity_yes" value='1' " />
					<label for="report_integrity_yes" class="fw-semibold align-middle"> a. The general reputation of 						<u> _ _ _ <span id="employee_name_yes"> {{$acr->employee->shriName }} </span> _ _ _ </u> for honesty
						is good and I certify his / her integrity. </label>
				</div>
				<hr/>
				<div class="col-md-12">
					<input type="radio" class="align-middle" name="report_integrity" id="report_integrity_no" value='0'" />
					<label for="report_integrity_no" class="fw-semibold align-middle"> b. The general reputation of
						<u> _ _ _ <span id="employee_name_no"> _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ </span> _ _ _ </u> <br/>
						for honesty is not good and I withhold his / her integrity on account of the following reasons.  </label>
				</div>
				
				<hr/>
				<div class="col-md-12">
					<input type="radio" class="align-middle" name="report_integrity" id="report_integrity_with_held" value='-1'" />
					<label for="report_integrity_with_held" class="fw-semibold align-middle"> 
						c.  Not Decided  </label>
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
		$('input[type=radio][name="report_integrity"]').change(function () {
			
			if($(this).attr('value') == "1")
			{
				$("#employee_name_yes").html("{{$acr->employee->shriName }}");
				$("#employee_name_no").html(" _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ ");
				$("#lbl_reason").removeClass('required');
				$("#reason").removeAttr('required');
				$("#reason").val('');
			}
			else if ($(this).attr('value') == "0")  
			{
				$("#employee_name_yes").html(" _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ ");
				$("#employee_name_no").html('{{$acr->employee->shriName }} ');

				$("#lbl_reason").addClass('required');				
				$("#reason").prop('required',true);
				$("#reason").css('background-color','antiquewhite');
				$("#reason").focus();

			}else
			{
				$("#employee_name_yes").html(" _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ ");
				$("#employee_name_no").html(" _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ ");
				
				$("#lbl_reason").addClass('required');				
				$("#reason").prop('required',true);
				$("#reason").css('background-color','antiquewhite');
				$("#reason").focus();
			}
        });
	});
</script>

@endsection
