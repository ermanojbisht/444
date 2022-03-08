@extends('layouts.type200.main')

@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
@include('layouts._commonpartials.css._select2')
@endsection
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection

@section('pagetitle')
@if ($acr->acr_type_id == 0)
	<small> Assign Officers </small>  Defaulters ACR
@else
	Part 1 ( Basic Information ) <small> Assign Officers </small>
@endif

@endsection

@section('breadcrumb')
	@if ($acr->acr_type_id == 0)
		@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
		['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
		['label'=> 'View All Defaulters Acrs', 'route'=>'acr.others.defaulters' ,'routefielddata' => 0,'active'=>false],
		['label'=> 'Assign Officers','active'=>true]
		]])
	@else
		@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
		['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
		['label'=> 'My Acrs', 'route'=>'acr.myacrs' ,'active'=>false],
		['label'=> 'Assign Officers','active'=>true]
		]])
	@endif
@endsection

@section('content')
@php
	$total_period = $acr->from_date->diffInDays($acr->to_date)+1;
@endphp
<div class="card shadow-lg p-0 mb-5 bg-body rounded" style="position: relative; ">
	<div class="card-body">
		<a  href="{{ url()->previous() }}" class="text-end" 
			style=" position: absolute; top: 10px; right: 10px;"
			onmouseover="this.style.color='#ff0000'"
			onmouseout="this.style.color='#00F'">
			<svg class="icon icon-xl">
				<use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-x-circle')}}"></use>
			</svg>
		</a>
		@if(!$acr->isSubmitted())
			<div class="d-flex justify-content-between" >
				<p class="fw-semibold fs-5 ">
					Assign Reporting, Reviewing and Accepting Officer <br>
					<small>
						For ACR Period {{$acr->from_date->format('d M Y')}} to {{$acr->to_date->format('d M Y')}} ({{$total_period}} Days) 
						<a href="{{route('acr.edit',['acr'=>$acr->id ])}}" class="btn badge rounded-pill bg-danger">Edit Period</a>
					</small> 
				</p>
			</div>
		@endif	
	
		@if(!$acr->isSubmitted())
			<input type="button" id="assign_Officials" class="btn btn-outline-primary mb-3" value="Assign Officials" />
		@endif
		@forelse($appraisalOfficers as $key=>$appraisalOfficer)
			<div class="card mb-3">
				<div class="card-header bg-dark text-light d-flex justify-content-between">
					<p class="fw-semibold fs-5 p-0 m-0">{{config('acr.basic.appraisalOfficerType')[$key]??''}} Officers List</p>
					<form  action="{{ route('acr.deleteAcrOfficers', [ 'acr_id'=> $acr->id, 'appraisal_officer_type'=>$key]) }}" method="POST" >
						{{ csrf_field() }}
						<button type="submit" class="btn btn-sm  btn-light "> 
							<svg class="icon">
								<use xlink:href={{asset('vendors/@coreui/icons/svg/free.svg#cil-trash')}}></use>
							</svg>
							Clear All {{config('acr.basic.appraisalOfficerType')[$key]??''}} Officers
						</button>
					</form>
				</div>
				<div class="card-body">
					@php 
						$reporting_days = 0;
						$dates = []; 
					@endphp
			    	<table class="table table-sm">
					    @foreach ($appraisalOfficer as $reporting_Officer)
			    		<tr class="@if($reporting_Officer->pivot->is_due == 1) bg-light @endif">
					    	@php 
					    		$reporting_days = $reporting_days + Carbon\Carbon::parse($reporting_Officer->pivot->from_date)->diffInDays(Carbon\Carbon::parse($reporting_Officer->pivot->to_date)) + 1;
					    		array_push($dates, $reporting_Officer->pivot->from_date);
					    		array_push($dates, $reporting_Officer->pivot->to_date);
					    	@endphp
					    	<td>{{$loop->iteration}}</td>
					    	<td>{{$reporting_Officer->name}}</td>
					    	<td>
					    		{{Carbon\Carbon::parse($reporting_Officer->pivot->from_date)->format('d M Y')}} 
					    				to 
					    		{{Carbon\Carbon::parse($reporting_Officer->pivot->to_date)->format('d M Y')}}
					    	</td>
					    	<td>
					    		{{Carbon\Carbon::parse($reporting_Officer->pivot->from_date)->diffInDays(Carbon\Carbon::parse($reporting_Officer->pivot->to_date)) +1 }} Days
					    	</td>
					    	<td>
					    		@if($reporting_Officer->pivot->is_due == 1)
					    			<span class="text-success">Due</span>
					    		@else
					    			<span class="text-danger">Not Due</span> 
					    		@endif
					    	</td>
			    		</tr>
					  	@endforeach

			    	</table>
			    	@php
			    		$checkStartDaysGap = $acr->from_date->diffInDays(Carbon\Carbon::parse(min($dates)));
			    		$checkEndDaysGap = $acr->to_date->diffInDays(Carbon\Carbon::parse(max($dates)));
			    	@endphp
			    		@if($checkStartDaysGap !=0)
					  		<p class="text-danger p-0 m-0">Start Date of {{config('acr.basic.appraisalOfficerType')[$key]??''}} Officers dose not match with ACR Start Date</p>
			    		@endif
			    		@if($checkEndDaysGap !=0)
					  		<p class="text-danger p-0 m-0">End Date of {{config('acr.basic.appraisalOfficerType')[$key]??''}} Officers dose not match with ACR End Date</p>
			    		@endif
				</div>
				<div class="card-footer text-muted d-flex justify-content-between">
					@if($reporting_days != $total_period)
						<p class="p-0 m-0 text-danger">Period for {{$total_period - $reporting_days}} Days Missing</p>
					@else
						 <p class="p-0 m-0 ">ok</p>
					@endif
					<p class="p-0 m-0 text-info">{{config('acr.basic.appraisalOfficerType')[$key]??''}} Selected for Total {{$reporting_days}} Days</p> 
				</div>
			</div>
		@empty
			<p class="text-center text-info fw-semibold fs-5">Please Click on [Assign Officials] Button to Add Assign Reporting, Reviewing and Accepting Officer</p>
		@endforelse
	</div>
</div>

<div>
	<!-- boostrap model -->

	<div class="modal fade" id="hrms-model" aria-hidden="true" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-light py-1">
					<p class="modal-title fw-bold" id="OfficialType">
						Add Appraisal Officers<br>
						<small>for Period : {{ $acr->from_date->format('d M Y') }} to {{ $acr->to_date->format('d M Y') }}</small>
					</p>
				</div>
				<div class="modal-body">
					<form id="officerInsertUpdateForm" name="officerInsertUpdateForm" class="form-horizontal"
						method="POST" action="{{route('acr.addAcrOfficers')}}">
						@csrf
						<div class="form-group mt-2">
							{!! Form::label('Select officer Authority', '', ['class' => 'required'] ) !!}
							<select id="appraisal_officer_type" name="appraisal_officer_type" class="form-select"
								required>
								<option value="" disabled selected> Select</option>
								@if($acr->isTwoStep)
									@php $officers=config('acr.basic.appraisalOfficerType2step'); @endphp
								@else
									@php $officers=config('acr.basic.appraisalOfficerType'); @endphp
								@endif
								@foreach($officers as $key => $value)								
								<option value="{{$key}}" {{ old('appraisal_officer_type')==$key ? 'selected' : '' }}>
									{{$value}} Authority
								</option>
								@endforeach
							</select>
						</div>
						<br />
						<div class="row">
							<div class="form-group col-md-6">
								{!! Form::label('section', 'Service Class', []) !!}
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
						<br />
						<div class="row">
							<div class="form-group">
								<label class="required" for="employee_id">Select officer</label>
								<br />
								<select name="employee_id" id="employee_id" required
									class="form-select select2 {{ $errors->has('employee_id') ? 'is-invalid' : '' }}">
								</select>
								@if($errors->has('employee_id'))
								<div class="invalid-feedback">
									{{ $errors->first('employee_id') }}
								</div>
								@endif
								<span class="help-block"></span>
							</div>
							<div class="p-2">
								<div id="employee_detail_div" class="bg-info text-white p-3"></div>
							</div>
						</div>
						<br />
						<div class="row">
							<p> Period of Appraisal : </p>
							<div class="row">
								<div class="col-md-6">
									<label for='from_date' class="required "> Enter From Date </label>
									<input type="date" id="from_date" name="from_date" onblur="findDateDiff()"
										placeholder="dd-mm-yyyy" value="{{ $acr->from_date->format('Y-m-d') }}" required
										class="form-control" />
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
				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="form-group mt-2">
							<input type="hidden" name="acr_id" value="{{$acr->id}}" />
							<input id="removeLogged" type="hidden" name="removeLogged" value="true" />
							<input type="submit" class="btn btn-primary " id="btnSave" value="Add Officers " />
						</div>
					</div>
				</div>
				</form>
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
			const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; 
			$("#days_in_number").html("Your Period of Appraisal  is for " + diffDays + " Days");
		}
	}

</script>

@include('partials.js._makeDropDown')

@endsection