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
<div class="card">
	<div class="card-body">
		<form class="form-horizontal" method="POST" action="{{route('acr.form.store2')}}">
			@csrf
			<input type="hidden" name="acr_id" value='{{$acr->id}}'>
			<div class="form-group">
			  <label for="good_work" class="fw-bold h4">
			  	2- Exceptionally good works done, if any, apart from routine duties during the period of appraisal (Max. 100 Words)
			  </label>
			  <textarea class="form-control rounded-0" id="good_work"  name="good_work" rows="5">
			  		{{$acr->good_work??''}}
			  </textarea>
			  <label for="difficultie" class="fw-bold h4">
			  	3- Difficulties faced in performing the assigned 'Tasks/Duties' (Max. 100 Words)
			  </label>
			  <textarea class="form-control rounded-0" id="difficultie"  name="difficultie" rows="5">
			  		{{$acr->difficultie??''}}
			  </textarea>
			</div>

		<div class="form-group mt-2">
	        <button type="submit" class="btn btn-primary " >Save
	    </div>
		</form>
	</div>
</div>
@endsection