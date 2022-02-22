<div class="d-flex justify-content-between p-2 bg-white border border-2">
	<span class="fw-semibold h5 text-muted">
		ACR of {{$acr->employee->shriName}} as {{$acr->type->description}}
	</span>
	<span>
		<div class="btn-group" role="group" aria-label="Basic outlined example">
		  	<a href="{{route('acr.form.create1',['acr' => $acr])}}"
		  		class="btn 
				  	@if($page ==1 ) btn-primary 
				  	@else btn-outline-primary
				  	@endif
		  		">Page-1</a>
		  <a href="{{route('acr.form.create2',['acr' => $acr])}}"
		  	class="btn 
				  	@if($page ==2 ) btn-primary 
				  	@else btn-outline-primary
				  	@endif
		  		">Page-2</a>
		  <a href="{{route('acr.form.create3',['acr' => $acr])}}"
		  	class="btn 
				  	@if($page ==3 ) btn-primary 
				  	@else btn-outline-primary
				  	@endif
		  		">Page-3</a>
		  <a href="{{route('acr.form.addTrainningToEmployee',['acr' => $acr])}}"
		  	class="btn 
				  	@if($page ==4 ) btn-primary 
				  	@else btn-outline-primary
				  	@endif
		  		">Trainnings</a>
		</div>
	</span>
</div>
