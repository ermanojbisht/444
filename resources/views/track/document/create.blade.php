{{-- @extends('layouts.type100.main') --}}
@extends('layouts.type200.main')
@section('styles')
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection

@section('side_menu')
    @include('layouts.type100.partials.side_menu',['active'=>'estimate_doc_list','instance_estimate_id'=>$instanceEstimate->id])
@endsection

@section('content')

<div class="container-fluid">
    <x-track.instance-estimate-header :instanceEstimate="$instanceEstimate" pagetitle="Add Document"
                                      toBackroutename="instance.estimate.doclist-1"
                                      :routeParameter="['instance_estimate'=>$instanceEstimate->id]"
                                      routelabel="Back to Document List"/>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body card-block">
                {{-- form --}}
                <form action="{{ route('instance.estimate.storeDocInTnstanceEstimate') }}" method="post"
                      enctype="multipart/form-data" class="">
                    {{ csrf_field() }}
                    <input type="hidden" name="instance_estimate_id" value="{{ $instanceEstimate->id }}">
                    <div class="row">
                        {{-- documenttype --}}
                        <div class="form-group col-md-2 {{ $errors->has('documenttype') ? ' has-error' : '' }} ">
                            <label class="required">Document Type</label>
                            <select name="documenttype" class="form-control required" size="1">
                                <option value="">Select Document Type</option>
                                @foreach($docTypes as $docType)
                                    <option value="{{ $docType->id }}"
                                            @if(old('documenttype')==$docType->id) selected @endif>{{ $docType->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('documenttype'))
                                <span class="help-block text-danger">
                        <strong>{{ $errors->first('documenttype') }}</strong>
                    </span>
                            @endif
                        </div>
                        {{-- doctitle --}}
                        <div class="form-group col-md-6 {{ $errors->has('doctitle') ? ' has-error' : '' }}">
                            <label class="required">Title</label>
                            <span class="help-block text-success pull-right">
                        <small>* Title should be short and unique for this work</small>
                    </span>
                            <input type="text" name="doctitle" class="form-control required"
                                   value="{{ old('doctitle') }} ">
                            @if ($errors->has('doctitle'))
                                <span class="help-block text-danger">
                        <strong>{{ $errors->first('doctitle') }}</strong>
                    </span>
                            @endif
                        </div>
                        {{-- version --}}
                        <div class="form-group col-md-1 {{ $errors->has('version') ? ' has-error' : '' }}">
                            <label class="required">Version</label>
                            <input type="text" name="version" class="form-control required"
                                   value="{{ old('version')??1 }}">
                            @if ($errors->has('version'))
                                <span class="help-block text-danger">
                        <strong>{{ $errors->first('version') }}</strong>
                    </span>
                            @endif
                        </div>
                        {{-- date doe --}}
                        <div class="form-group col-md-3 ">
                            <label class="required" for="doe">Date of Document generation</label>
                            <div class="input-group date datepicker {{ $errors->has('doe') ? 'is-invalid' : '' }}"
                                 id="datepicker" data-date-end-date="0d">
                                <input type="text" class="form-control" name="doe" id="doe" value="{{ old('doe')}}"
                                       required>
                                <span class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </span>
                                @if($errors->has('doe'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('doe') }}
                                    </div>
                                @endif
                            </div>
                        </div>
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
                        <label for="uploaded_file">Upload File</label>
                        <input id="uploaded_file" type="file" class="form-control" name="uploaded_file">
                        @if ($errors->has('uploaded_file'))
                            <span class="help-block text-danger">
                            <strong>{{ $errors->first('uploaded_file') }}</strong>
                        </span>
                        @endif
                    </div>

                    {{-- description --}}
                    <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                        <label>Description</label>
                        <textarea name="description" class="form-control"></textarea>
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
@section('footscripts')
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js "></script>
    <script>
        $(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                orientation: 'bottom',
            })
        });

    </script>
@endsection
