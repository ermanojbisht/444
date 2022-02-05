@extends('layouts.type200.main')

@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
@include('layouts._commonpartials.css._select2')
@endsection
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection

@section('pagetitle')
My ACR Appraisal Officers for Duration {{ $acr->from_date->format('d M Y') }} to {{ $acr->to_date->format('d M Y') }}
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
['label'=> 'My Acrs', 'route'=>'acr.myacrs' ,'active'=>false],
['label'=> 'My Acr Appraisal Officers','active'=>true]
]])
@endsection

@section('content')

<div class="card">

	@if(!$acr->isSubmitted())

	<div class="row">
		<div class="col-md-3">
			<input type="button" id="assign_Officials" class="btn btn-primary " value="Assign Officials" />
		</div>
		<div class="col-md-3">
			@if($acr->hasAppraisalOfficer(1))
			<form action="{{ route('acr.deleteAcrOfficers', [ 'acr_id'=> $acr->id, 'appraisal_officer_type'=>1]) }}"
				method="POST">
				{{ csrf_field() }}
				<button type="submit" class="btn btn-danger "> Delete Reporting Officials</button>
			</form>
			@endif
		</div>
		<div class="col-md-3">
			@if($acr->hasAppraisalOfficer(2))
			<form action="{{ route('acr.deleteAcrOfficers', [ 'acr_id'=> $acr->id, 'appraisal_officer_type'=>2]) }}"
				method="POST">
				{{ csrf_field() }}
				<button type="submit" class="btn btn-danger "> Delete Reviewing Officials</button>
			</form>
			@endif
		</div>
		<div class="col-md-3">
			@if($acr->hasAppraisalOfficer(3))
			<form action="{{ route('acr.deleteAcrOfficers', [ 'acr_id'=> $acr->id, 'appraisal_officer_type'=>3]) }}"
				method="POST">
				{{ csrf_field() }}
				<button type="submit" class="btn btn-danger "> Delete Accepting Officials</button>
			</form>
			@endif
		</div>

	</div>

	@endif
	<table class="table datatable table-bordered table-striped table-hover">
		<thead>
			<tr>
				<th>Appraisal Officer Type </th>
				<th>Officer Name </th>
				<th>From Date</th>
				<th>To Date</th>
				<th>Period </th>
				<th>Is Due </th>
			</tr>
		</thead>
		<tbody>
			@forelse ($appraisalOfficers as $appraisalOfficer)
			<tr>
				<td> {{ config('acr.basic.appraisalOfficerType')[$appraisalOfficer->pivot->appraisal_officer_type] }}
				</td>
				<td>{{$appraisalOfficer->name}}</td>
				<td>{{$appraisalOfficer->pivot->from_date}}</td>
				<td>{{$appraisalOfficer->pivot->to_date}}</td>
				<td>{{Carbon\Carbon::parse($appraisalOfficer->pivot->from_date)->diffInDays(Carbon\Carbon::parse($appraisalOfficer->pivot->to_date))
					}} Days</td>
				<td> {{ config('site.yesNo')[$appraisalOfficer->pivot->is_due] }}</td>
			</tr>
			@empty
			<tr>
				<td colspan="5" rowspan="1" headers="">No Data Found</td>
			</tr>
			@endforelse
		</tbody>
	</table>
</div>

<div>
	<!-- boostrap model -->

	<div class="modal fade" id="hrms-model" aria-hidden="true" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="OfficialType"></h4>
				</div>
				<div class="modal-body">
					<form id="officerInsertUpdateForm" name="officerInsertUpdateForm" class="form-horizontal"
						method="POST" action="{{route('acr.addAcrOfficers')}}">
						@csrf
						<div class="form-group mt-2">
							{!! Form::label('Select officer ', '', ['class' => 'required'] ) !!}
							<select id="appraisal_officer_type" name="appraisal_officer_type" class="form-select"
								required>
								<option value=""> Select Officer </option>
								@foreach(config('acr.basic.appraisalOfficerType') as $key => $value)
								<option value="{{$key}}" {{ old('appraisal_officer_type')==$key ? 'selected' : '' }}>
									{{$value}}
								</option>
								@endforeach
							</select>
						</div>
						<div class="row">
							<div class="form-group col-md-6">
								{!! Form::label('section', 'Section', []) !!}
								{!! Form::select('section', ['All'=>'All','A'=>'A','B'=>'B','C'=>'C','D'=>'D'], 'All',
								['id'=>'section','class'=>'form-select']) !!}
							</div>
							<div class="form-group col-md-6">
								{!! Form::label('employeeType', 'Employee Type', []) !!}
								{!! Form::select('employeeType',
								['All'=>'All','er'=>'Engineer','office'=>'Office','other'=>'Other'], 'All',
								['id'=>'employeeType','class'=>'form-select']) !!}
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-12">
								<div class="form-group">
									<label class="required" for="employee_id">Select officer</label>
									<select
										class="form-select select2 {{ $errors->has('employee_id') ? 'is-invalid' : '' }}"
										name="employee_id" id="employee_id" required>
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
							<p> Period of Appraisal : </p>
							<div class="row">
								<div class="col-md-6">
									<label for='from_date' class="required "> Enter From Date </label>
									<input type="date" id="from_date" name="from_date" onblur="findDateDiff()"
										value="{{ $acr->from_date->format('Y-m-d') }}" required class="form-control" />
								</div>
								<div class="col-md-6">
									<label for='to_date' class="required "> Enter To Date </label>
									<input type="date" id="to_date" name="to_date" onblur="findDateDiff()"
										value="{{ $acr->to_date->format('Y-m-d') }}" required class="form-control" />
								</div>

								<div class="col-md-12">
									<div class="text-success" id="days_in_number"></div>
								</div>
							</div>
						</div>
						<div class="form-group mt-2">
						</div>
						<div class="row">
							<div class="form-group mt-2">
								<input type="hidden" name="acr_id" value="{{$acr->id}}" />
                                <input id="removeLogged" type="hidden" name="removeLogged" value="true" />
								<input type="submit" class="btn btn-primary " id="btnSave" value="Add Officers " />
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

	});
 
    $(document).ready(function() {

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

</script>

@include('partials.js._makeDropDown')

@endsection
