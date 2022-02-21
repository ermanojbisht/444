@extends('layouts.type200.pdf')

@section('content')

<div class="card">
	<div class="card-header">
		<p class="card-title fw-semibold h5">Part -II Self Appraisal</p> 
	</div>
	<div class="card-body text-muted">
		<p class="fw-bold h5">
		  	स्वयं द्वारा किए गए कार्यों के संबंध मे विवरण व स्वयं का विश्लेषण (अधिकतम 300 शब्दों मे)
		</p>
		<p class="text-info border border-primary p-3" style="min-height: 150px;">
			{{$acr->good_work??' ----  '}}
		</p>
	</div>

</div>
@endsection
