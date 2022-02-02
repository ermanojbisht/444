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
		Training .. . .. . . . . .
	</div>
</div>
@endsection