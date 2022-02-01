@extends('layouts.type200.main')
@section('content')
{{$acr->type->description}}
<hr>
<div class="card">
	<div class="card-body">
		<form class="form-horizontal" method="POST" action="{{route('acr.form.store2')}}">
			@csrf
			<input type="hidden" name="acr_id" value='{{$acr->id}}'>
			<div class="form-group">
			  <label for="good_work" class="fw-bold h4">
			  	2- Exceptionally good works done, if any, apart from routine duties during the period of appraisal (Max. 100 Words)
			  </label>
			  <textarea class="form-control rounded-0" id="good_work"  name="good_work" rows="5"></textarea>
			  <label for="difficultie" class="fw-bold h4">
			  	3- Difficulties faced in performing the assigned 'Tasks/Duties' (Max. 100 Words)
			  </label>
			  <textarea class="form-control rounded-0" id="difficultie"  name="difficultie" rows="5"></textarea>
			</div>

		<div class="form-group mt-2">
	        <button type="submit" class="btn btn-primary " >Save
	    </div>
		</form>
	</div>
</div>
@endsection