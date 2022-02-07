@extends('layouts.type200.main')
@section('sidebarmenu')
	@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection
@section('pagetitle')
	Part -II Self-Appraisal <small>Page -2</small>
@endsection
@section('content')
	@if(!$view)
		@include('employee.acr.form._formHeader',['acr'=>$acr])
	@endif
	<div class="card">
		<div class="card-body">
			<form class="form-horizontal" method="POST" action="{{route('acr.form.store2')}}">
				@csrf
				<input type="hidden" name="acr_id" value='{{$acr->id}}'>
				<div class="form-group">
					<label for="good_work" class="fw-bold h5">
					  	2- Exceptionally good works done, if any, apart from routine duties during the period of appraisal (Max. 100 Words)
					</label>
					@if(!$view)
						<textarea class="form-control rounded-0" id="good_work"  name="good_work" rows="3"
						  	@if(!empty($acr->good_work))
								style="background-color:#F0FFF0;"
							@endif
						>{{$acr->good_work??''}}</textarea>
					@else
						<p class="text-info">{{$acr->good_work??'--no data filled--'}}</p>
					@endif
				  	<label for="difficultie" class="fw-bold h5">
				  		3- Difficulties faced in performing the assigned 'Tasks/Duties' (Max. 100 Words)
				  	</label>
				  	@if(!$view)
					  	<textarea class="form-control rounded-0" id="difficultie"  name="difficultie" rows="3"
					  	@if(!empty($acr->difficultie))
								style="background-color:#F0FFF0;"
							@endif
						>{{$acr->difficultie??''}}</textarea>
				  	@else
				  		<p class="text-info">{{$acr->difficultie??'--no data filled--'}}</p>
				  	@endif
				</div>
			@if(!$view)
				<div class="form-group mt-2 text-end">
			        <button type="submit" class="btn btn-primary">Save
			    </div>
		    @endif
			</form>
		</div>
	</div>
@endsection