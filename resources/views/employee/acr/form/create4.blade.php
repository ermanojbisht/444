@extends('layouts.type200.main')
@section('content')
<div class="d-flex justify-content-between">
	<span>
		{{$acr->type->description}}
	</span>
	<span>
		<div class="btn-group" role="group" aria-label="Basic outlined example">
		  <a class="btn btn-outline-primary" href="{{route('acr.form.create1',['acr' => $acr])}}">Part-1</a>
		  <a class="btn btn-outline-primary" href="{{route('acr.form.create2',['acr' => $acr])}}">Part-2</a>
		  <a class="btn btn-outline-primary" href="{{route('acr.form.create3',['acr' => $acr])}}">Part-3</a>
		  <a class="btn btn-outline-primary" href="{{route('acr.form.create4',['acr' => $acr])}}">Part-4</a>
		</div>
	</span>
</div><hr>
<div class="card form-control">
	<div class="card-header">
		Training .. . .. . . . . .
	</div>
	<form class="form-horizontal" method="POST" action="{{route('acr.form.store4')}}">
		@csrf
		<input type="hidden" name="employee_id" value='{{$acr->employee_id}}'/>
		@foreach($master_trainings as $key=>$trainings)
		<div class="card-body">
			<P class="fw-bold h4">
				{{$key}}
			</P>
			@foreach($trainings as $training)
				<div class="form-check">
				  <input class="form-check-input" type="checkbox" value="{{$training->id}}" name="training[]" id="training{{$training->id}}">
				  <label class="form-check-label" for="training{{$training->id}}">
				    {{$training->description}}
				  </label>
				</div>
			@endforeach
		</div>
		@endforeach
		<button type="submit" class="btn btn-primary">Save
	</form>
</div>
@endsection