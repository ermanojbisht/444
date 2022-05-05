@extends('layouts.type200.main')

@section('styles')
@include('layouts._commonpartials.css._select2')
@include('layouts._commonpartials.css._datatable')
@endsection
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection

@section('pagetitle')
Edit Legacy ACR
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
['label'=> 'Legacy Acr','route'=> 'acr.others.legacy', 'routefielddata' => $creater->employee->office_idd, 'active'=>false],
['label'=> 'Add Others ACR' ,'active'=>true]
]])
@endsection

@section('content')

<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<form id="officerInsertUpdateForm" name="officerInsertUpdateForm" class="form-horizontal" method="POST"
					action="{{route('acr.others.legacyupdate')}}">
					@csrf
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
					<div class="row">
						<div class="col-md-4">
							<p class="fw-bold"> Selected Office :-</p>
						</div>
						<div class="col-md-6">
							<p class="fw-semibold text-info"> {{$acr->office->name}} </p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<p class="fw-bold"> Period of Appraisal :-</p>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-3">
									{!! Form::label('from_date', $acr->from_date->format('d M Y'),
									['class'=>'fw-semibold text-info']) !!}
								</div>
								<div class="col-md-1 " style="text-align: :left;"> - </div>
								<div class="col-md-3">
									{!! Form::label('to_date', $acr->to_date->format('d M Y'), ['class'=>'fw-semibold
									text-info']) !!}
								</div>
								<div class="col-md-12">
									<div class="text-success" id="days_in_number"></div>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
		<hr />

		<input type="checkbox" name="is_Final_Acr" id="is_Final_Acr" onclick="fillFinalAcr(this)" checked required />
		{!! Form::label('is_Final_Acr', 'Is ACR Finalized (यदि ए०सी०आर० पुर्ण हो चुकी है तो चेकबॉक्स tick
		करें)', []) !!}
		<hr />


		<div class="row">
			<div class="col-md-3">
				{!! Form::label('report_no', 'Reporting No', []) !!}
				<input type="text" id="report_no" name="report_no" value="{{$acr->report_no }}" class="form-control" />
			</div>

			<div class="col-md-9">
				{!! Form::label('appraisal_note_1', 'Remark for Report', ['class'=>'required']) !!}
				<input type="text" id="appraisal_note_1" name="appraisal_note_1" value="{{$acr->appraisal_note_1 }}"
					class="form-control required" />
			</div>
		</div>

		<div class="row">
			<div class="col-md-3">
				{!! Form::label('review_no', 'Review No', []) !!}

				<input type="text" id="review_no" name="review_no" value="{{$acr->review_no }}" class="form-control" />
			</div>
			<div class="col-md-9">
				{!! Form::label('report_no', 'Remark for Review', ['class'=>'required']) !!}
				<input type="text" id="appraisal_note_2" name="appraisal_note_2" value="{{$acr->appraisal_note_2 }}"
					class="form-control required" />
			</div>
		</div>

		<div class="row">
			<div class="col-md-3">
				{!! Form::label('accept_no', 'Accept No', []) !!}
				<input type="text" id="accept_no" name="accept_no" value="{{$acr->accept_no }}" class="form-control" />
			</div>
			<div class="col-md-9">
				{!! Form::label('report_no', 'Remark for Accept', ['class'=>'required']) !!}
				<input type="text" id="appraisal_note_3" name="appraisal_note_3" value="{{$acr->appraisal_note_3 }}"
					class="form-control required" />
			</div>

		</div>

		<div class="row">
			<div class="form-group col-md-3">
				{!! Form::label('report_integrity', 'Select integrity', []) !!}
				<select id="report_integrity" name="report_integrity" class="form-select"
					onchange="checkFillIntegrity()">
					<option value="1" {{( $acr->report_integrity == 1 ? 'selected' : '' )}} > Yes</option>
					<option value="0" {{( $acr->report_integrity == 0 ? 'selected' : '' )}} > No</option>
					<option value="-1" {{( $acr->report_integrity == -1 ? 'selected' : '' )}} > Withhold </option>
				</select>
			</div>
			<div class="form-group col-md-9">
				{!! Form::label('report_remark', 'If integrity has been withhold then state the
				reasons otherwise leave blank ', []) !!}

				<textarea class="form-control" rows=2 id="report_remark" name="report_remark" disabled>{{$acr->report_remark}} 
				</textarea>

			</div>
		</div>
		<div class="form-group mt-2">
		</div>
		<div class="row">
			<div class="form-group mt-2">
				<input id="removeLogged" type="hidden" name="removeLogged" value="true" />
				<input type="hidden" name="acr_type_id" value="0" />
				<input type="hidden" name="acr_id" value="{{$acr->id}}" />
				<input type="submit" class="btn btn-primary " id="btnSave" value="Update" />
			</div>
		</div>
		</form>

	</div>

</div>
<hr />
<br />
</div>
</div>

@endsection


@section('footscripts')
@include('layouts._commonpartials.js._select2')
@include('partials.js._employeeSelect2DropDownJs')
@include('partials.js._employeeDDProcessHelperJs')
@include('layouts._commonpartials.js._datatable')



<script type="text/javascript">
	$(document).ready(function () {
		$("#office_id").select2(); 
		checkFillIntegrity();
	});
	
	function checkFillIntegrity()
	{
		var integrity = $("#report_integrity").val(); 
		if(integrity == "1")
		{
			$("#report_remark").val(""); 
			$("#report_remark").attr("disabled", "disabled"); 
		}else
		{
			$("#report_remark").removeAttr("disabled"); 
		}
	}

	function fillFinalAcr($chkFinalACR)
	{
		if($("#" + $chkFinalACR.id).is(":checked"))
		{
			$("#report_no").removeAttr("disabled"); 
			$("#appraisal_note_1").removeAttr("disabled"); 
			$("#review_no").removeAttr("disabled"); 
			$("#appraisal_note_2").removeAttr("disabled"); 
			$("#accept_no").removeAttr("disabled"); 
			$("#appraisal_note_3").removeAttr("disabled"); 

			$("#appraisal_note_1").attr("required", "required"); 
			$("#appraisal_note_2").attr("required", "required"); 
			$("#appraisal_note_3").attr("required", "required"); 


			
		}else
		{
			//$("#report_no").removeAttr("required"); 
			//$("#review_no").removeAttr("require"); 
			//$("#accept_no").removeAttr("require"); 

			$("#appraisal_note_1").removeAttr("require"); 
			$("#appraisal_note_2").removeAttr("require"); 
			$("#appraisal_note_3").removeAttr("require"); 

			$("#report_no").attr("disabled", "disabled"); 
			$("#appraisal_note_1").attr("disabled", "disabled"); 
			$("#review_no").attr("disabled", "disabled"); 
			$("#appraisal_note_2").attr("disabled", "disabled"); 
			$("#accept_no").attr("disabled", "disabled"); 
			$("#appraisal_note_3").attr("disabled", "disabled"); 
			
		}
	}


</script>

@include('partials.js._makeDropDown')

@endsection