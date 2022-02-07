@extends('layouts.type200.main')
@section('sidebarmenu')
	@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection
@section('pagetitle')
	Part -II Self-Appraisal <small>Page -4 Required Trainings</small>
@endsection
@section('content')
 	@include('employee.acr.form._formHeader',['acr'=>$acr])
	<div class="card form-control">
		<p class="fs-5 fw-bold">5- Please Select training modules for indicate specific areas in which you feel the need to upgrade your skills through training programs (Maximum 4 modules)</p>
		<form class="form-horizontal" method="POST" action="{{route('acr.form.store4')}}">
			@csrf
			<input type="hidden" name="employee_id" value='{{$acr->employee_id}}'/>
			@foreach($master_trainings as $key=>$trainings)
			<div class="card-body">
				<P class="fw-semibold h5 text-muted">
					{{$key}}
				</P>
				<div class="row">
					@foreach($trainings as $training)
						<div class="form-check col-md-4  fs-5">
						  <input class="form-check-input" type="checkbox" value="{{$training->id}}" name="training[]" id="training{{$training->id}}" 
 								@if ($selected_trainings->contains($training->id))
							  		checked
							  	@endif
						  >
						  <label class="form-check-label" for="training{{$training->id}}">
						    {{$training->description}}
						  </label>
						</div>
					@endforeach
				</div>
			</div>
			<hr>
			@endforeach
			<div class="text-end">
				<button type="submit" class="btn btn-primary">Save
			</div>
		</form>
	</div>
@endsection