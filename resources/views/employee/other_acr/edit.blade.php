@extends('layouts.type200.main')

@section('styles')
@include('layouts._commonpartials.css._select2')
@endsection
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection

@section('pagetitle')
Edit <small> Legacy ACR </small>
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
// ['label'=> 'My Acrs', 'route'=>'acr.others.legacy' ,'active'=>false],
['label'=> 'Edit ACR','active'=>true]
]])
@endsection

@section('content')
<div class="card shadow-lg p-0 mb-5 bg-body rounded" style="position: relative; ">
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
							<p class="fw-semibold text-info"> {{$employee->shriName }} </p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<p class="fw-bold"> Date of Birth :-</p>
						</div>
						<div class="col-md-6">
							<p class="fw-semibold text-info"> {{$employee->birth_date->format('d M Y')}} </p>
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
			<hr>
			<div class="row">
				<div class="col-md-3">
					{!! Form::label('report_no', 'Reporting No', []) !!}
					{!! Form::text('report_no', $acr->report_no, ['class'=>'form-control']) !!}
				</div>
				<div class="col-md-9">
					{!! Form::label('report_no', 'Remark for Report', ['class'=>'required']) !!}
					{!! Form::text('appraisal_note_1', $acr->appraisal_note_1 , ['id'=>'appraisal_note_1',
					'class'=>'form-control', 'required']) !!}
				</div>
			</div>

			<div class="row">
				<div class="col-md-3">
					{!! Form::label('review_no', 'Review No', []) !!}
					{!! Form::text('review_no', $acr->review_no, ['class'=>'form-control' ]) !!}
				</div>
				<div class="col-md-9">
					{!! Form::label('report_no', 'Remark for Review', ['class'=>'required']) !!}
					{!! Form::text('appraisal_note_2', $acr->appraisal_note_2 , ['id'=>'appraisal_note_2',
					'class'=>'form-control', 'required']) !!}
				</div>
			</div>

			<div class="row">
				<div class="col-md-3">
					{!! Form::label('accept_no', 'Accept No', []) !!}
					{!! Form::text('accept_no', $acr->accept_no, ['class'=>'form-control']) !!}
				</div>
				<div class="col-md-9">
					{!! Form::label('report_no', 'Remark for Accept', ['class'=>'required']) !!}
					{!! Form::text('appraisal_note_3', $acr->appraisal_note_3, ['id'=>'appraisal_note_3',
					'class'=>'form-control', 'required']) !!}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-12"> 
					{!! Form::label('report_remark', 'If integrity has been withhold then state the
					reasons otherwise leave blank', []) !!}
					{!! Form::textarea('report_remark', $acr->report_remark, ['class'=>'form-control', 'rows'=>2]) !!}
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
</div>
</div>


@endsection


@section('footscripts')
<script type="text/javascript">
	$(document).ready(function () {

		$('.select2').select2({
		});
	});
</script>


@include('layouts._commonpartials.js._select2')
@include('partials.js._employeeSelect2DropDownJs')

@include('partials.js._makeDropDown')

@endsection