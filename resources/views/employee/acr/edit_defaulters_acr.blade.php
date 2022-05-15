@extends('layouts.type200.main')

@section('styles')
@include('layouts._commonpartials.css._select2')
@endsection
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection

@section('pagetitle')
  <small> Edit Other's ACR </small>
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
['label'=> 'View All Initiated Acrs', 'route'=>'acr.others.defaulters' ,'routefielddata' => 0,'active'=>false],
['label'=> 'Edit Others ACR','active'=>true]
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
				<p class="fw-semibold  text-info"> {{$acr->employee->shriName }} </p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<p class="fw-bold"> Date of Birth :-</p>
			</div>
			<div class="col-md-6">
				<p class="fw-semibold  text-info"> {{$acr->employee->birth_date->format('d M Y')}} </p>
			</div>
		</div>
		<hr />
		<form class="form-horizontal" method="POST" action="{{route('acr.others.update')}}">
			@csrf
			{{-- <div class="row mb-3"> todo ankit
				<div class="col-md-12">
					<p class="fw-semibold "> Select Type of ACR to be Filled : </p>
				</div>
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
			</div>			 --}}
			<div class="row">
				<div class="col-md-4">
					<p class="fw-semibold"> Period Of Appraisal : </p>
				</div>
				<div class="col-md-4">
					<label for='from_date' class="required "> Enter From Date </label>
					<input type="date" name="from_date" value="{{$acr->from_date->format('Y-m-d') }}" required
						class="form-control" />
				</div>
				<div class="col-md-4">
					<label for='to_date' class="required "> Enter To Date </label>
					<input type="date" name="to_date" value="{{$acr->to_date->format('Y-m-d') }}" required
						class="form-control" />
				</div>

				<hr class="m-1" style="opacity: 0.1;">
				<div class="col-md-4">
					<p class="fw-semibold"> Place of Posting During the Appraisal Period : </p>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						{{ Form::label('office_id','Select Office Name',[ 'class'=>' required']) }}
						<select id="office_id" name="office_id" required class="form-select select2">
							<option value=""> Select Office </option>
							@foreach ($Offices as $key => $values)
							<option value="{{$key}}" {{($acr->office_id==$key)?'selected':''}}> {{$values}} </option>
							@endforeach
							{{-- @foreach ($Offices as $office)
							<option value="{{$office->id}}" {{( $acr_office->id == $office->id ?
								'selected' : '' )}} > {{$office->name}} </option>
							@endforeach --}}
						</select>
					</div>
				</div>
				<hr class="m-1" style="opacity: 0.1;">

				<hr class="m-1" style="opacity: 0.1;">
				<div class="col-md-4">
					<p class="fw-semibold  "> Education Qualification : -</p>
				</div>
				<div class="col-md-8">
					@foreach ($employee->education as $education )
					@if($education->emp_year <=  $employee->joining_date->format('Y'))
					<p> <span class="fw-semibold h6"> At the time of Joining in the Department : - </span>
						<span class="text-info"> {{$education->qualifiaction }} </span>
					</p>					
					@else
					<p>
						<span class="fw-semibold h6"> Acquired during service in the Department : - </span>
						<span class="text-info"> {{$education->qualifiaction }} </span>
					</p>
					@endif
					@endforeach
				</div>
				<hr class="m-1" style="opacity: 0.1;">
				<p>Note:- Text in <span class="text-info">Blue color</span> from HRMS Data, if any Correction contact to
					Office Administrator</p>
			</div>
			<div class="row">
				<div class="col-md-3">
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

		$('.select2').select2({
		});

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

        });
</script>

@include('partials.js._makeDropDown')

@endsection
