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
['label'=> 'Acr ','active'=>false],
['label'=> 'Create','active'=>true]
]])
@endsection

@section('content')
<div class="card">
	<div class="card-body">
		<form class="form-horizontal" method="POST" action="{{route('acr.store')}}">
			@csrf

			<div class="form-group">
				<div class="row">
					<div class="col-md-4">
						<p class="fw-bold h5"> Name of the officer Reported Upon :- </p>
					</div>
					<div class="col-md-6">
						<p class="fw-bold"> {{$employee->name }} </p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<p class="fw-bold h5"> Date of Birth :-</p>
					</div>
					<div class="col-md-6">
						<p class="fw-bold "> {{$employee->birth_date->format('d M Y')}} </p>
					</div>
				</div>
			</div>
			<br />


			<div class="row">
				<div class="col-md-6">
					<p class="fw-bold h5"> Select Type of ACR to be Filled : </p>
					<div class="row">
						<div class="col-md-6">
							<label for='acr_group_id' class="required "> Select Designation Group </label>
							<select id="acr_group_id" name="acr_group_id" required class="form-select">
								<option value=""> Select ACR Type </option>
								@foreach ($acrGroups as $key=>$name)
								<option value="{{$key}}"> {{$name}} </option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6">
							<label for='acr_type_id' class="required "> Select Acr Type </label>
							<select id="acr_type_id" name="acr_type_id" required class="form-select">
							</select>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<p class="fw-bold h5"> Period Of Appraisal : </p>

					<div class="row">
						<div class="col-md-6">
							<label for='from_date' class="required "> Enter From Date </label>
							<input type="date" name="from_date" required class="form-control" />
						</div>
						<div class="col-md-6">
							<label for='to_date' class="required "> Enter To Date </label>
							<input type="date" name="to_date" required class="form-control" />
						</div>
					</div>

				</div>
			</div>

			<br />
			<div class="row">
				<div class="col-md-6">
					<p class="fw-bold h5"> During the Appraisal Period : </p>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('officeType','Place of Posting ',[ 'class'=>' required']) }}
								{{ Form::select('officeType',($Officetypes),old('officeType'),['placeholder'=>'Select
								Office
								Type','id'=>'officeTypeId','class'=>'form-select', 'required']) }}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('office_id','Select Office Name',[ 'class'=>' required']) }}
								<select id="office_id" name="office_id" required class="form-select select2">
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-md-12">
					<p class="fw-bold h5"> Education Qualification : </p>
					@foreach ($employee->education as $education )
					@if($education->qualifiaction_type_id == 1)
					<div class="row">
						<div class="col-md-4">
							<p class="fw-bold h6"> At the time of Joining in the Department  </p>
						</div>
						<div class="col-md-6">
							{{$education->qualifiaction }}
						</div>
					</div>
					@endif
					@if($education->qualifiaction_type_id == 2)
					<div class="row">
						<div class="col-md-4">
							<p class="fw-bold h6"> Qualification acquired during service in the Department  </p>
						</div>
						<div class="col-md-6">
							{{$education->qualifiaction }}
						</div>
					</div>
					@endif
					@endforeach
				</div>
			</div>

			<br />
			<div class="row">
				<div class="col-md-12">
					<p class="fw-bold h5"> Membership of any Professional Organization : - </p>
					<input type="text" class="form-control" name="professionalOrganization" /> 
					 {{-- ToDo: to be save in which table in DB  --}}
				</div>
			</div>
			<br />
			<br />
			<div class="row">
				<div class="col-md-3">
					<input type="hidden" name="employee_id" value="{{$employee->id}}" />
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

        });
</script>


@include('layouts._commonpartials.js._select2')
@include('partials.js._employeeSelect2DropDownJs')
@include('partials.js._employeeDDProcessHelperJs')

@include('partials.js._makeDropDown')

@endsection