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
['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
['label'=> 'My Acrs', 'route'=>'acr.myacrs' ,'active'=>false],
['label'=> 'View Acr','active'=>true]
]])
@endsection

@section('content')


<hr>

<div class="card">
	<div class="card-body">
		<form class="form-horizontal" method="POST" action="{{route('acr.update')}}">
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
							<label for='acr_group_id' class="h6  "> Designation Group : </label>
							<br />

							@foreach ($acrGroups as $key=>$name)
							@if ($acr_selected_group_type->acr_group_id == $key )
							<label id="acr_group_id" name="acr_group_id"> {{$name}} </label>
							@endif
							@endforeach
							</select>
						</div>
						<div class="col-md-6">
							<label for='acr_type_id' class="h6  "> Acr Type </label> <br />
							@foreach ($acr_Types as $acr_type)
							@if ($acr_selected_group_type->id == $acr_type->id)
							<label> {{$acr_type->name}} </label>
							@endif
							@endforeach
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<p class="fw-bold h5"> Period Of Appraisal : </p>
					<div class="row">
						<div class="col-md-6">
							<label for='from_date' class=" h6  "> Enter From Date </label>
							<br />
							<label name="from_date"> </label>{{$acr->from_date->format('d M Y') }} </label>
						</div>
						<div class="col-md-6">
							<label for='to_date' class=" h6  "> Enter To Date </label>
							<br />
							<label name="to_date"> {{$acr->to_date->format('d M Y') }}" </label>
						</div>
					</div>

				</div>

			</div>


			<div class="row">

				<div class="col-md-6">
					<p class="fw-bold h5">  During the Appraisal Period : </p>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('officeType','Place of Posting ',[ 'class'=>'  h6']) }}
								<br />
								@foreach ($Officetypes as $key=>$name)
								@if ($key==$acr_office->office_type)
								<label id='officeTypeId'> {{$name}} </label>
								@endif
								@endforeach
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('office_id','Select Office Name',[ 'class'=>' h6']) }}
								<br />
								@foreach ($Offices as $office)
								@if ($acr_office->id == $office->id)
								<label> {{$office->name}} </label>
								@endif
								@endforeach
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
				<div class="col-md-12">
					<p class="fw-bold h5"> Membership of any Professional Organization : - </p>
					<label type="text" class="form-control" name="professionalOrganization"></label>
					{{-- ToDo: to be save in which table in DB --}}
				</div>
			</div>
			<br />
			<br />

			<div class="row">
				<div class="col-md-3">
					<input type="hidden" name="employee_id" value="{{$employee->id}}" />
					<input type="hidden" name="acr_id" value="{{$acr->id}}" />
				</div>
			</div>
		</form>
	</div>
</div>


@endsection


@section('footscripts')
@endsection