@extends('layouts.type200.main')
@section('sidebarmenu')
	@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection
@section('pagetitle')
	Part -II Self-Appraisal <small>Page -2</small>
@endsection
@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
['label'=> 'My Acrs', 'route'=>'acr.myacrs' ,'active'=>false],
['label'=> 'Assessment of Performance','active'=>true]
]])
@endsection

@section('content')
	<div class="mb-3">
		@include('employee.acr.form._formHeader',['acr'=>$acr])
	</div>
	<div class="card border border-2 shadow-lg p-0 mb-5 bg-body rounded">
		<div class="card-body">
			<a  href="{{ url()->previous() }}" class="text-end" 
				style=" position: absolute; top: 10px; right: 10px;"
				onmouseover="this.style.color='#ff0000'"
				onmouseout="this.style.color='#00F'">
				<svg class="icon icon-xl">
					<use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-x-circle')}}"></use>
				</svg>
			</a>
			<form class="form-horizontal" method="POST" action="{{route('acr.form.store2')}}">
				@csrf
				<input type="hidden" name="acr_id" value='{{$acr->id}}'>
				<div class="form-group">
					<label for="good_work" class="fw-bold h5">
					  	2- Exceptionally good works done, if any, apart from routine duties during the period of appraisal (Max. 100 Words)
					</label>
					<textarea class="form-control rounded-0" id="good_work"  name="good_work" rows="5"
					  	@if(!empty($acr->good_work))
							style="background-color:#F0FFF0;"
						@endif
					>{{$acr->good_work??''}}</textarea>
					<p class="my-3"></p>
				  	<label for="difficultie" class="fw-bold h5">
				  		3- Difficulties faced in performing the assigned 'Tasks/Duties' (Max. 100 Words)
				  	</label>
				  	<textarea class="form-control rounded-0" id="difficultie"  name="difficultie" rows="5"
				  	@if(!empty($acr->difficultie))
							style="background-color:#F0FFF0;"
						@endif
					>{{$acr->difficultie??''}}</textarea>
				</div>
				<div class="d-flex justify-content-between mt-3">
			    	<a  class="btn btn-primary" href="{{ url()->previous() }}"> Back </a>
			    	<button type="submit" class="btn btn-primary">Save and Continue</button>
				</div>
			</form>
		</div>
	</div>
@endsection