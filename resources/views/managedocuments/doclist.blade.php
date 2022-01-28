@extends('layouts.type50.min')
@section('headscript')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/datatables/media/css/jquery.dataTables.css') }}"/>
<link href="{{ asset('plugins/toggle/css/bootstrap-toggle.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@include('partials.workheaderPartial',[
    'pagetitle'=>"Available Documents of Project",
    'toBackroutename'=>"admin.works.show",
    'routeParameter'=>['work'=>$workcode],
    'anchorifAny'=>"",
    'work_name'=>$workname,
    'workcode'=>$workcode,
])
    @include('partials.search_doc',['formaction'=>'searchDoc','fieldName'=>'work_code','fieldValue'=>$workcode])
	@if($workcode)
    Docs are editable only for {{config('site.backdate.docUploadInWorks.allowedno')}} days.
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-12">
							<span class="pull-right"> for document Type: {{ $doctypeName }}</span></strong>
						</div>
					</div>
				</div>
					<div class="card-body">
					    <div class="row">
							<div class="col-sm-12">
								<a href="{{ url("adddocument").'/'.$workcode }}" class="btn btn-primary btn-flat pull-right mt-2 mr-2">Add Document</a>
								<a href="{{ url("exportdoclist").'/'.$workcode.'/'.$doctypeid }}" class="btn btn-primary btn-flat pull-right mt-2 mr-2">Export To Excel</a>
							</div>
						</div>
						<div>&nbsp;</div>
						<table class="table datatable table-bordered table-striped table-hover" id="progresstbl">
							<thead>
								<tr>
									<th>Sno.</th>
									<th>ID</th>
									<th>Name</th>
									<th>Description</th>
									<th>Type</th>
									<th>Date</th>
									{{-- @can('edit-document')
									<th>Edit</th>
									@endcan --}}
									@can('publish-document')
										<th></th>
									@endcan
								</tr>
							</thead>
							<tbody>
								@php $sno = 0; @endphp
								@forelse($doclist as $doc)
								<tr>
									<td>{{ ++$sno }}</td>
									<td>{{ $doc->id }}</td>
									<td><a href="{{ $doc->address }}" target="_blank">{{ $doc->name }}</a></td>
									<td>{{ $doc->description }}</td>
									<td>{{ $doc->documentTypeGeneral->name}}</td>
									<td>{{ $doc->created_at->toFormattedDateString() }}</td>
									@can('edit-document')
									{{-- <td><a href="{{ url('editdocument').'/'.$doc->id }}"><i class="fa fa-pencil"></i></a></td> --}}
									@endcan
									@can('publish-document')
									<td>
										@if($doc->is_active)
											@php $icon="fa-check"; $textclass="text-success"; @endphp
										@else
											@php $icon="fa-times"; $textclass="text-danger"; @endphp
										@endif
										<a href="{{ url('publishdocument').'/'.$doc->id.'/'.$doc->is_active }}" class="{{ $textclass }}"><i class="fa {{ $icon }}"></i></a>
									</td>
									@endcan
								</tr>
								@empty
								<tr><td colspan="6">No Document found.</td></tr>
								@endforelse
							</tbody>
						</table>
				</div>
			</div>
		</div>
	</div>
	@endif
@endsection
@section('footscript')
<script type="text/javascript" language="javascript" src="{{ asset('assets/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/toggle/js/bootstrap-toggle.min.js') }}"></script>
<script type="text/javascript" language="javascript" class="init">
	var $ =jQuery.noConflict();
	$(document).ready(function() {
    $('.datatable').DataTable({
        processing: false,
        serverSide: false,
    	});
	});
</script>
@endsection
