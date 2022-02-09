@extends('layouts.type200.main')

@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
@endsection
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection

@section('pagetitle')
Part 1 ( Basic Information ) <small> Edit ACR </small>
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
['label'=> 'My Acrs', 'route'=>'acr.myacrs' ,'active'=>false],
['label'=> 'Edit ACR','active'=>true]
]])
@endsection

@section('content')
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-4">
				<p class="fw-bold"> Name of the officer Reported Upon :- </p>
			</div>
			<div class="col-md-6">
				<p class="fw-semibold"> {{$employee->name }} </p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<p class="fw-bold"> Date of Birth :-</p>
			</div>
			<div class="col-md-6">
				<p class="fw-semibold "> {{$employee->birth_date->format('d M Y')}} </p>
			</div>
		</div>
		<hr />
		<form class="form-horizontal" method="POST" action="{{route('acr.update')}}">
			@csrf
			<div class="row">
				<div class="col-md-4">
					<p class="fw-semibold"> Select Type of ACR to be Filled : </p>
				</div>
				<div class="col-md-4">
					<label for='acr_group_id' class="required "> Select Designation Group </label>
					<select id="acr_group_id" name="acr_group_id" required class="form-select">
						<option value=""> Select ACR Type </option>
						@foreach ($acrGroups as $key=>$name)
						<option value="{{$key}}" {{( $acr_selected_group_type->group_id == $key ?
							'selected' : '' )}} > {{$name}} </option>
						@endforeach
					</select>
				</div>
				<div class="col-md-4">
					<label for='acr_type_id' class="required "> Select Acr Type </label>
					<select id="acr_type_id" name="acr_type_id" required class="form-select">
						@foreach ($acr_Types as $acr_type)
						<option value="{{$acr_type->id}}" {{( $acr_selected_group_type->id == $acr_type->id ?
							'selected' : '' )}} > {{$acr_type->name}} </option>
						@endforeach
					</select>
				</div>
				<hr class="m-1" style="opacity: 0.1;">

			</div>
			<div class="col-md-6">
				<p class="fw-bold"> Period Of Appraisal : </p>
				<div class="row">
					<div class="col-md-6">
						<label for='from_date' class="required "> Enter From Date </label>
						<input type="date" name="from_date" value="{{$acr->from_date->format('Y-m-d') }}" required
							class="form-control" />
					</div>
					<div class="col-md-6">
						<label for='to_date' class="required "> Enter To Date </label>
						<input type="date" name="to_date" value="{{$acr->to_date->format('Y-m-d') }}" required
							class="form-control" />
					</div>
				</div>
			</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<h5> During the Appraisal Period : </h5>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						{{ Form::label('officeType','Place of Posting ',[ 'class'=>' required']) }}
						<select id='officeTypeId' class='form-select' required>
							@foreach ($Officetypes as $key=>$name)
							<option value="{{$key}}" {{( (old('officeTypeId')==$key || $key==$acr_office->
								office_type) ? 'selected' : '' )}}> {{$name}} </option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						{{ Form::label('office_id','Select Office Name',[ 'class'=>' required']) }}
						<select id="office_id" name="office_id" required class="form-select">
							@foreach ($Offices as $office)
							<option value="{{$office->id}}" {{( $acr_office->id == $office->id ?
								'selected' : '' )}} > {{$office->name}} </option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<p class="fw-bold required"> Date of filing Property Return for the Calander Year: - </p>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<input type="date" class="form-control"
							value="{{$acr->property_filing_return_at ? $acr->property_filing_return_at->format('Y-m-d') : '' }}"
							name="property_filing_return_at" />
					</div>
				</div>
			</div>
		</div>

		<br />
		<div class="row">
			<div class="col-md-12">
				<p class="fw-bold"> Membership of any Professional Organization : - </p>
				<textarea type="text" class="form-control"
					name="professional_org_membership"> {{ $acr->professional_org_membership }} {{old('professional_org_membership')}}</textarea>
			</div>
		</div>
		<br />

	</div>
	<br />
	<div class="row">
		<div class="col-md-12">
			<p class="fw-bold"> Education Qualification : </p>
			@foreach ($employee->education as $education )
			@if($education->qualifiaction_type_id == 1)
			<div class="row">
				<div class="col-md-4">
					<p class="fw-bold h6"> At the time of Joining in the Department : - </p>
				</div>
				<div class="col-md-6">
					{{$education->qualifiaction }}
				</div>
			</div>
			@endif
			@if($education->qualifiaction_type_id == 2)
			<div class="row">
				<div class="col-md-4">
					<p class="fw-bold h6"> Qualification acquired during service in the Department : - </p>
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
		<div class="col-md-3">
			<input type="hidden" name="employee_id" value="{{$employee->id}}" />
			<input type="hidden" name="acr_id" value="{{$acr->id}}" />
			<input type="submit" class="btn btn-primary " value="Update ACR" />
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

@include('partials.js._makeDropDown')

@endsection