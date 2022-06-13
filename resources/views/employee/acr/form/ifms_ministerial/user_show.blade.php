@extends('layouts.type200.pdf')

@section('content')

<div class="card">
	<div class="card-header">
		<p class="card-title fw-semibold h5">Part -II Self Appraisal</p> 
	</div>
	<div class="card-body text-muted">
			<p class="text-info text-center fw-semibold h5">Part -II Self Appraisal Filled By Employee</p>
			<p class="fw-semibold text-info">आलोच्य अवधि मे आवंटित उत्तरदायित्व व प्राप्त उपलब्धि/ कार्यों का संक्षिप्त विवरण</p>
			<table class="table table-bordered border-info">
				<thead class="fw-bold border-info text">
					<tr class="text-center align-middle">
						<th class="text-info">क्रमांक</th>
						<th class="text-info">समयावधि</th>
						<th class="text-info">आवंटित उत्तरदायित्व</th>
						<th class="text-info">अवधि के दोरान प्राप्त उपलब्धि/ कार्य का विवरण</th>
					</tr>
				</thead>
				<tbody>
						@foreach($acr->fillednegativeparameters as $data)
							<tr>
								<td class="text-info">{{$data->row_no}}</td>
								<td class="text-info">{{$data->col_1}}</td>
								<td class="text-info">{{$data->col_2}}</td>
								<td class="text-info">{{$data->col_3}}</td>
							</tr>
						@endforeach
				</tbody>
			</table>
	</div>

</div>
@endsection
