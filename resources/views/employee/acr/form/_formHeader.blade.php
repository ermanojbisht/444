<div class="d-flex justify-content-between p-2 bg-white">
	<span class="fw-semibold h5 text-muted">
		ACR of {{$acr->employee->name}} as {{$acr->type->description}}
	</span>
	<span>
		<div class="btn-group" role="group" aria-label="Basic outlined example">
		  <a class="btn btn-outline-primary" href="{{route('acr.form.create1',['acr' => $acr])}}">Part-1</a>
		  <a class="btn btn-outline-primary" href="{{route('acr.form.create2',['acr' => $acr])}}">Part-2</a>
		  <a class="btn btn-outline-primary" href="{{route('acr.form.create3',['acr' => $acr])}}">Part-3</a>
		  <a class="btn btn-outline-primary" href="{{route('acr.form.create4',['acr' => $acr])}}">Part-4</a>
		  <a class="btn btn-outline-danger" href="{{route('acr.form.appraisal1',['acr' => $acr])}}">Appraisal</a>
		</div>
	</span>
</div>