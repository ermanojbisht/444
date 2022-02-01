@extends('layouts.type200.main')

@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
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


<hr>

<div class="card">

</div>
<div class="card">
	<form class="form-horizontal" method="POST" action="{{route('acr.store')}}">
		@csrf

		<div class="row">

			<div class="col-md-6">
				<h5> Select Type of ACR to be Filled : </h5>

				<div class="row">
					<div class="col-md-6">
						<label for='acr_group_id' class="required "> Select Designation Group </label>
						<select id="acr_group_id" name="acr_group_id" required class="form-control">
							<option value=""> Select ACR Type </option>
							@foreach ($acrGroups as $key=>$name)
								<option value="{{$key}}"> {{$name}} </option>
							@endforeach
						</select>
					</div>

					<div class="col-md-6">
						<label for='acr_type_id' class="required "> Select Acr Type </label>
						<select id="acr_type_id" name="acr_type_id" required class="form-control">
						</select>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<h5> Period Of Appraisal : </h5>

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


		<div class="row">

			<div class="col-md-6">
				<h5> During the Appraisal Period : </h5>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							{{ Form::label('officeType','Place of Posting ',[ 'class'=>'  required']) }}
							{{ Form::select('officeType',($Officetypes),old('officeType'),['placeholder'=>'Select Office
							Type','id'=>'officeTypeId','class'=>'form-control', 'required']) }}
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							{{ Form::label('office_id','Select Office Name',[ 'class'=>'  required']) }}
							<select id="office_id" name="office_id" required class="form-control">
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<h5>   </h5>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<br/>
							{{ Form::label('office_id','Date Of Birth ',[ 'class'=>'  required']) }}
							<label> {{$employee->birth_date->format('d M Y')}} </label>
						</div>
					</div>
				</div>


		</div>

		<div class="row">
			<div class="col-md-3">
				<input type="hidden" name="employee_id" value="{{$employee->id}}" />
				<input type="submit" class="btn btn-primary " value="Save" />
			</div>
		</div>
	</form>
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