@extends('layouts.type50.min')
@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection
@section('headscript')
<link rel="stylesheet" href="{{ asset('/css/font.css')}}">
@endsection


@section('content')
<div class="col-sm-12">
    <b>Work Name:</b><span class=""> {{$work->WORK_name}}</span>
    <br>
    {{$work->work_nick}}
    <br>
    <b>{{$work->WORK_code}}</b>
	<div class="card">
		<div class="card-header">
			<strong>Documents</strong>
		</div>
		<div class="card-body card-block">
			{{-- form --}}		 
			<form action="{{ url('savedocument') }}" method="post" enctype="multipart/form-data" class="">
				{{ csrf_field() }}				
			    <input type="hidden" name="work_code" value="{{ $work->WORK_code }}">
			    {{-- documenttype --}}
                <div class="form-group {{ $errors->has('documenttype') ? ' has-error' : '' }} ">
					<label>Document Type</label>
					<select name="documenttype" class="form-control required" size="1">
						<option value="">Select Document Type</option>
						@foreach($docTypes as $docType)
							<option value="{{ $docType->id }}" @if(old('documenttype')==$docType->id) selected @endif>{{ $docType->name }}</option>
						@endforeach
					</select>
					@if ($errors->has('documenttype'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('documenttype') }}</strong>
                    </span>
                	@endif
				</div>
				{{-- doctitle --}}
				<div class="form-group {{ $errors->has('doctitle') ? ' has-error' : '' }}">
					<label>Title</label>
					<span class="help-block text-success pull-right">
                        <small>* Title should be short and unique for this work</small>
                    </span>
					<input type="text" name="doctitle" class="form-control required" value="{{ old('doctitle') }} ">
                    @if ($errors->has('doctitle'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('doctitle') }}</strong>
                    </span>
                	@endif
				</div>
				{{-- externallink --}}
				<div class="form-group {{ $errors->has('externallink') ? ' has-error' : '' }}">
					<label>External Link</label>
					<input type="text" name="externallink" class="form-control" value="{{ old('externallink') }}">
    				@if ($errors->has('externallink'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('externallink') }}</strong>
                        </span>
                    @endif
                </div>
				<div class="text-center">Or</div>
				<span class="help-block text-success pull-right">
                    <small>Upload file or external link, use only one </small>
                </span>
				{{-- uploaded_file --}}
				<div class="form-group{{ $errors->has('uploaded_file') ? ' has-error' : '' }}">
                    <label for="uploaded_file" >Upload File</label>
                    <input id="uploaded_file" type="file" class="form-control" name="uploaded_file">
                    @if ($errors->has('uploaded_file'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('uploaded_file') }}</strong>
                        </span>
                    @endif
                </div>
                {{-- version --}}
                <div class="form-group {{ $errors->has('version') ? ' has-error' : '' }}">
                    <label>Version</label>
                    <input type="text" name="version" class="form-control required" value="{{ old('version')??1 }}" >
                    @if ($errors->has('version'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('version') }}</strong>
                    </span>
                    @endif
                </div>
                {{-- description --}}
    			<div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
    				<label>Description</label>
    				<textarea name="description" class="form-control"></textarea>
    			</div>
                {{-- date doe --}}
                <div class="form-group">
                    <label class="required" for="doe">Date of Document generation</label>
                    <div class="input-group date datepicker {{ $errors->has('doe') ? 'is-invalid' : '' }}" id="datepicker" data-date-end-date="0d">
                    <input type="text" class="form-control" name="doe" id="doe" value="{{ old('doe')}}" required>
                    <span class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </span>
                    @if($errors->has('doe'))
                    <div class="invalid-feedback">
                        {{ $errors->first('doe') }}
                    </div>
                    @endif
                </div>
                {{-- lat long --}}
                <div class="row">
                    <div class="col-sm-6">
        				<div class="form-group {{ $errors->has('lat') ? ' has-error' : '' }}">
        					<label>Lattitude</label>
        					<span class="help-block text-success pull-right">
                                <small>* Lattitude should be filled only in case of Pics/video</small>
                            </span>
        					<input type="text" name="lat" class="form-control" value="{{ old('lat') }} ">
                            @if ($errors->has('lat'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('lat') }}</strong>
                            </span>
                        	@endif
        				</div>
                    </div>

                    <div class="col-sm-6">
        				<div class="form-group {{ $errors->has('lng') ? ' has-error' : '' }}">
        					<label>Longitude</label>
        					<span class="help-block text-success pull-right">
                                <small>* Longitude should be filled only in case of Pics/video</small>
                            </span>
        					<input type="text" name="lng" class="form-control" value="{{ old('lng') }} ">
                            @if ($errors->has('lng'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('lng') }}</strong>
                            </span>
                        	@endif
        				</div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
				<button type="submit" name="saveBtn" class="btn btn-flat btn-primary pull-right">Save Document</button>
            </div>
			</form>
		</div>
	</div>
</div>
@endsection
@section('footscript')
{{-- <script type="text/javascript">
	var $=jQuery.noConflict();
	$(document).ready(function(){
		@if(old('completionact')==1)
			$('.cmpdiv').show();
		@else
			$('.cmpdiv').hide();
		@endif
	})
	function showdiv(val){
		if(val==1){
			$('.cmpdiv').show();
		}
		else{
			$('.cmpdiv').hide();
		}
	}
</script> --}}
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
