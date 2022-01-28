@extends('layouts.type50.app')
@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection
@section('headscript')
@endsection

@section('content')

<div class="col-sm-6">
	<div class="card">
		<div class="card-header">
			<strong>Sub Activity</strong>
		</div>
		<div class="card-body card-block">
			<form action="{{ url('/updatedocument').'/'.$docdetails->id }}" method="post" class="">
				<input name="_method" type="hidden" value="PATCH">
				{{ csrf_field() }}
			   @if(count($errors))
		            <ul class="text-danger list-unstyled">
		            @foreach($errors->all() as $error)
							<li>{{ $error }}</li>
					@endforeach
					</ul>
				@endif
				<div class="form-group">
					<label>Project</label>
					<select name="project" class="form-control" size="1">
						<option value="">Select Project</option>
						@foreach($projects as $project)
							<option value="{{ $project->id }}" @if($docdetails->project_id==$project->id) selected @endif>{{ $project->title }}</option>
						@endforeach
					</select>
				</div>
                <div class="form-group">
					<label>Document Type</label>
					<select name="documenttype" class="form-control" size="1">
						<option value="">Select Document Type</option>
						@foreach($docTypes as $docType)
							<option value="{{ $docType->id }}" @if($docdetails->doctype_id==$docType->id) selected @endif>{{ $docType->name }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label>Title</label>
					<input type="text" name="doctitle" class="form-control" value="{{ $docdetails->name }}">
				</div>
				<div class="form-group">
		            <label class="required" for="doe">Date of Document generation</label>
		            <div class="input-group date datepicker {{ $errors->has('doe') ? 'is-invalid' : '' }}" id="datepicker" data-date-end-date="0d">
		                <input type="text" class="form-control" name="doe" id="doe" value="{{ $docdetails->doe}}" required>
		                <span class="input-group-append">
		                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
		                </span>
		            </div>
		            @if($errors->has('doe'))
		                <div class="invalid-feedback">
		                    {{ $errors->first('doe') }}
		                </div>
		            @endif
		        </div>
				<div class="form-group">
					<label>External Link</label>
					<input type="text" name="externallink" class="form-control" value="{{ $docdetails->address }}">
				</div>
				<div class="form-group">
					<label>Description</label>
					<textarea name="description" class="form-control">{{ $docdetails->description }}</textarea>
				</div>
				<div class="form-group">
					<label>Lattitude , only in case of pics</label>
					<input type="text" name="lat" class="form-control" value="{{ $docdetails->lat }}">
				</div>
				<div class="form-group">
					<label>Longitude , only in case of pics</label>
					<input type="text" name="lng" class="form-control" value="{{ $docdetails->lng }}">
				</div>
            </div>

            <!-- /.box-body -->
            <div class="box-footer">

				<button type="submit" name="saveBtn" class="btn btn-flat btn-primary pull-right">Update Document</button>
            </div>
			</form>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js "></script>
<script>
    $(function () {
        $('.datepicker').datepicker({
            format:'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            orientation: 'bottom',
        })
    });

</script>    
@endsection
