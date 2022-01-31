@extends('layouts.type200.main')

@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
@endsection
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection

@section('pagetitle')
My ACR Appraisal Officers for Duration {{ $acr->from_date->format('d M Y') }} to {{ $acr->to_date->format('d M Y') }}
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
['label'=> 'Acr ','active'=>false],
['label'=> 'My Acr Appraisal Officers','active'=>true]
]])
@endsection

@section('content')

<div class="card">




	<!-- boostrap model -->
	<div class="modal fade" id="officer-model" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="OfficialType"></h4>
				</div>
				<div class="modal-body">
					<form action="javascript:void(0)" id="officerInsertUpdateForm" name="officerInsertUpdateForm"
						class="form-horizontal" method="POST">
						@csrf

						<div class="form-group mt-2">
							{!! Form::label('Select officer ', '', ['class' => 'required'] ) !!}
							<select id="appraisal_officer_type" name="appraisal_officer_type">
								<option value=""> Select Officer </option>
								<option value="1">Reviewing Officer </option>
								<option value="2">Reporting Officer </option>
								<option value="3">Accepting Officer </option>
							</select>
						</div>


						<div class="row">
							<div class="form-group col-md-6">
								{!! Form::label('section', 'Section', []) !!}
								{!! Form::select('section', ['All'=>'All','A'=>'A','B'=>'B','C'=>'C','D'=>'D'], 'All',
								['id'=>'section','class'=>'form-control']) !!}

							</div>
							<div class="form-group col-md-6">
								{!! Form::label('employeeType', 'Employee Type', []) !!}
								{!! Form::select('employeeType',
								['All'=>'All','er'=>'Engineer','office'=>'Office','other'=>'Other'], 'All',
								['id'=>'employeeType','class'=>'form-control']) !!}
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								{!! Form::label('Select Reviewing officer ', 'employee_id', ['class' => 'required'] ) !!}

								<select class="form-control select2 {{ $errors->has('employee_id') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id" required>
								</select>
								@if($errors->has('employee_id'))
									<div class="invalid-feedback">
										{{ $errors->first('employee_id') }}
									</div>
								@endif
								<span class="help-block">User Id</span>
							</div>
							<div class="form-group mt-2">
							</div>
						</div>
						<div class="form-group mt-2">
							<input type="hidden" name="acr_id" value="{{$acr->id}}" />
							<input type="submit" class="btn btn-primary " id="btnSave" value="Add Officers " />
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

	<input type="button" id="assign_Officials" href="javascript:void(0)" class="btn btn-primary delete"
		value="Assign Officials" />

	<table class="table datatable table-bordered table-striped table-hover">
		<thead>
			<tr>
				<th>Appraisal Officer Type </th>
				<th>Officer Name </th>
				<th>From Date</th>
				<th>To Date</th>
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






@endsection


@section('footscripts')
<script type="text/javascript">
	$(document).ready(function () {
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
			$('#officer-model').modal('show');
		});

	});
 
    $(document).ready(function() {
        let section= $( "#section" ).val();
        let employeeType= $( "#employeeType" ).val();

        $('#section').on('change', function() {
           section= this.value;
           employeeType= $( "#employeeType" ).val();
           employeeSelect2DropDown('#employee_id',minimumInputLength=3,employeeType,section);
        });


        $('#employeeType').on('change', function() {
           section= $( "#section" ).val();
           employeeType= this.value;
           employeeSelect2DropDown('#employee_id',minimumInputLength=3,employeeType,section);
        });
 
        employeeSelect2DropDown('#employee_id',minimumInputLength=3,employeeType='all',section='all');


        $('#employee_id').change(function(event) {
            $.ajax({
                url: '{{route('employee.basicData')}}',
                type: 'POST',
                //dataType: 'default',//causes error if data is not in jSON format
                data: {employee_id: $('#employee_id').val(),_token : $('meta[name="csrf-token"]').attr('content')},
                success: function (result,status,xhr) {
                    $('#employee_detail_div').html(result)
                },
                error: function (xhr,status,error) {
                    console.log("error",error,status);
                }
            });
        });

    });

</script>


@include('partials.js._employeeSelect2DropDownJs')
@include('partials.js._makeDropDown')

@endsection