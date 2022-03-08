@extends('layouts.type200.main')
@section('sidebarmenu')
	@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection
@section('pagetitle')
	Part -II Self-Appraisal <small>Page -4 Required Trainings</small>
@endsection
@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
['label'=> 'My Acrs', 'route'=>'acr.myacrs' ,'active'=>false],
['label'=> 'Required Trainings','active'=>true]
]])
@endsection

@section('content')
 	<div class="mb-3">
		@include('employee.acr.form._formHeader',['acr'=>$acr])
	</div>
	<div class="card form-control border-2 shadow-lg p-1 mb-5 bg-body rounded">
		<a  href="{{ url()->previous() }}" class="text-end" 
			style=" position: absolute; top: 10px; right: 10px;"
			onmouseover="this.style.color='#ff0000'"
			onmouseout="this.style.color='#00F'">
			<svg class="icon icon-xl">
				<use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-x-circle')}}"></use>
			</svg>
		</a>
		<p class="fs-5 fw-bold">5- Please Select training modules for indicate specific areas in which you feel the need to upgrade your skills through training programs (Maximum 4 modules)</p>
		<form class="form-horizontal" method="POST" action="{{route('acr.form.storeTrainning')}}">
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
			<div class="d-flex justify-content-between m-3">
				<a  class="btn btn-primary" href="{{ url()->previous() }}"> Back </a>
				<button type="submit" class="btn btn-primary">Save</button>
			</div>
		</form>
	</div>
@endsection
