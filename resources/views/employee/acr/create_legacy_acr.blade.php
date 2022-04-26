@extends('layouts.type200.main')

@section('styles')
@include('layouts._commonpartials.css._select2')
<style>
	.select2-selection {
		height: 39px !important;
	}
</style>
@endsection
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection

@section('pagetitle')
Add Legacy ACR Data
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
['label'=> 'Add Others ACR' ,'active'=>true]
]])
@endsection

@section('content')

<div class="card">
	<div class="card-body">
		<div class="btn-group" role="group" aria-label="Basic outlined example">
			<input type="button" id="assign_Officials" class="btn btn-outline-primary"
				value="Add Employee's Legacy ACR" />
		</div>
		<hr />
		<br />

		<table class="table border mb-0">
			<thead class="table-light  fw-bold">
				<tr class="align-middle">
					<th>#</th>
					<th>Employee Name</th>
					<th>Employee Id</th>
					<th>From Date</th>
					<th>To Date</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($legacyAcrs as $acr)
				<tr class="{!! $acr->status_bg_color() !!}" style="--cui-bg-opacity: .25;">
					<td>{{1+$loop->index }}</td>
					<td>{{ $acr->employee->shriName}}</td>
					<td>{{$acr->employee_id}} </td>
					<td>{{Carbon\Carbon::parse($acr->from_date)->format('d M Y')}}</td>
					<td>{{Carbon\Carbon::parse($acr->to_date)->format('d M Y')}}</td>
					<td>
						 
					</td>
					{{-- <td>
						<div class="dropdown dropstart">
							<button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown"
								aria-haspopup="true" aria-expanded="false">
								<svg class="icon icon-xl">
									<use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-options')}}">
									</use>
								</svg>
							</button>
							<div class="dropdown-menu dropdown-menu-end">
								 
								<a class="dropdown-item" href="{{route('acr.view', ['acr' => $acr->id])}}">
									<i class="cib-twitter"></i> View ACR
								</a>
								 
							</div>
						</div>
					</td> --}}
				</tr>
				@endforeach
			</tbody>
		</table>


	</div>
</div>

<div>
	<!-- boostrap model -->
	<div class="modal fade  " id="hrms-model" aria-hidden="true" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="OfficialType">
						Legacy ACR
					</h4>
				</div>
				<div class="modal-body">
					<form id="officerInsertUpdateForm" name="officerInsertUpdateForm" class="form-horizontal"
						method="POST" action="{{route('acr.others.legacystore')}}">
						@csrf
						<div class="row mb-3">
							<div class="form-group col-md-3">
								{!! Form::label('section', 'Service Class', []) !!}
								{!! Form::select('section', ['All'=>'All','A'=>'A','B'=>'B','C'=>'C','D'=>'D'], 'All',
								['id'=>'section','class'=>'form-select']) !!}
							</div>
							<div class="form-group col-md-3">
								{!! Form::label('employeeType', 'Employee Type', []) !!}
								{!! Form::select('employeeType',
								['All'=>'All','er'=>'Engineer','office'=>'Office','other'=>'Other'], 'All',
								['id'=>'employeeType','class'=>'form-select']) !!}
							</div>
							<div class="form-group col-md-6">
								<div class="form-group">
									<label class="required" for="employee_id">Select officer</label>
									<br />
									<select name="employee_id" id="employee_id" required style="width:100%;"
										class="form-select select2 {{ $errors->has('employee_id') ? 'is-invalid' : '' }}">
									</select>
									@if($errors->has('employee_id'))
									<div class="invalid-feedback">
										{{ $errors->first('employee_id') }}
									</div>
									@endif
									<span class="help-block"></span>
								</div>
							</div>

						</div>

						<div class="row">
							<div class="col-md-3">
								<p> &nbsp; </p> 
								<label for='office_id' class="required "> Select Office </label>
								<select name="office_id" id="office_id" required class="form-select select2">
									<option value=""> Select Office </option>
									@foreach ($Offices as $office)
									<option value="{{$office->id}}"> {{$office->name}} </option>
									@endforeach
								</select>
							</div>

							<div class="col-md-9">
								<p> Period of Appraisal : </p>
								<div class="row" style="border:1px dashed gainsboro">
									<div class="col-md-6">
										<label for='from_date' class="required "> Enter From Date </label>
										<input type="date" id="from_date" name="from_date" onblur="findDateDiff()"
											placeholder="dd-mm-yyyy" value="" required class="form-control" />
									</div>
									<div class="col-md-6">
										<label for='to_date' class="required "> Enter To Date </label>
										<input type="date" id="to_date" name="to_date" onblur="findDateDiff()" value=""
											required class="form-control" />
									</div>
									<div class="col-md-12">
										<div class="text-success" id="days_in_number"></div>
									</div>
								</div>
							</div>
						</div>

						<input type="checkbox" name="is_Final_Acr" id="is_Final_Acr" onclick="fillFinalAcr(this)" />
						{!! Form::label('is_Final_Acr', 'Is ACR Finalized (यदि ए०सी०आर० पुर्ण हो चुकी है तो चेकबॉक्स tick करें)', []) !!}

						<hr>

						<div class="row">
							<div class="col-md-3">
								{!! Form::label('report_no', 'Reporting No', []) !!}
								{!! Form::text('report_no', '' , ['class'=>'form-control', 'disabled'=>'disabled']) !!}
							</div>
							<div class="col-md-9">
								{!! Form::label('report_no', 'Remark for Report', ['class'=>'required']) !!}
								{!! Form::text('appraisal_note_1', '' , ['id'=>'appraisal_note_1',
								'class'=>'form-control', 'disabled'=>'disabled']) !!}
							</div>
						</div>

						<div class="row">
							<div class="col-md-3">
								{!! Form::label('review_no', 'Review No', []) !!}
								{!! Form::text('review_no', '' , ['class'=>'form-control', 'disabled'=>'disabled' ]) !!}
							</div>
							<div class="col-md-9">
								{!! Form::label('report_no', 'Remark for Review', ['class'=>'required']) !!}
								{!! Form::text('appraisal_note_2', '' , ['id'=>'appraisal_note_2',
								'class'=>'form-control', 'disabled'=>'disabled']) !!}
							</div>
						</div>

						<div class="row">
							<div class="col-md-3">
								{!! Form::label('accept_no', 'Accept No', []) !!}
								{!! Form::text('accept_no', '' , ['class'=>'form-control', 'disabled'=>'disabled']) !!}
							</div>
							<div class="col-md-9">
								{!! Form::label('report_no', 'Remark for Accept', ['class'=>'required']) !!}
								{!! Form::text('appraisal_note_3', '' , ['id'=>'appraisal_note_3',
								'class'=>'form-control', 'disabled'=>'disabled']) !!}
							</div>
						</div>

						<div class="row">
							<div class="form-group col-md-12">
								{!! Form::label('report_integrity', 'If integrity has been withhold then state the
								reasons otherwise leave blank ', []) !!}
								{!! Form::textarea('report_integrity', '' , ['class'=>'form-control', 'rows'=>2]) !!}
							</div>
						</div>
						<div class="form-group mt-2">
						</div>
						<div class="row">
							<div class="form-group mt-2">
								<input id="removeLogged" type="hidden" name="removeLogged" value="true" />
								<input type="hidden" name="acr_type_id" value="0" />
								<input type="submit" class="btn btn-primary " id="btnSave" value="SAVE" />
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<div id="employee_detail_div"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- end bootstrap model -->
</div>

@endsection


@section('footscripts')
@include('layouts._commonpartials.js._select2')
@include('partials.js._employeeSelect2DropDownJs')
@include('partials.js._employeeDDProcessHelperJs')
<script type="text/javascript">
	$(document).ready(function () {
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
		$('#officeTypeId').change(function (e) {
			e.preventDefault();
			$filterParam = $(this).val(); // or $('#officeTypeId').val();
			$.ajax
			({
				url: '{{ url('getOfficesfromOfficeType') }}/' + $filterParam,
				type: 'GET',
				success: function (data) {
					console.log(data); 
					bindDdlWithDataAndSetValue("office_id", data, "id", "name", true, "", "Select Office", "");
				}
			});
		});

		
		$('#acr_group_id').change(function (e) {
			e.preventDefault(); 
			$.ajax
			({
				url: "{{route('acr.getAcrType')}}",
				type: 'POST',
				data: {acr_group_id: $('#acr_group_id').val(), _token : $('meta[name="csrf-token"]').attr('content') },
				success: function (data) {
					console.log(data); 
					bindDdlWithDataAndSetValue("acr_type_id", data, "id", "name", true, "", "Select ACR Type", "");
				}
			});
		});
			
		$('#assign_Officials').click(function () {
			$('#hrms-model').modal('show');
		});

		findDateDiff();
 

	});
 
 
	function findDateDiff()
	{
		var from_date = new Date($("#from_date").val());
		var to_date = new Date($("#to_date").val());
		if(from_date != "" && to_date != "")
		{
			const diffTime = Math.abs(to_date - from_date);
			const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 

			$("#days_in_number").html("Your Period of Appraisal  is for " + diffDays + " Days");
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