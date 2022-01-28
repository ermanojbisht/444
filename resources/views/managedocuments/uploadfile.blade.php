@extends('layouts.type50.app')
@section('content')
 <div class="col-sm-6">
    <div class="card">
        <div class="card-header">
            <strong>Upload file</strong>
        </div>
        <div class="card-body card-block">
                <form class="form-horizontal" method="post" action="{{ route('uploadfiletodropbox') }}" enctype="multipart/form-data">
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
                            <option value="{{ $project->id }}" @if(old('project')==$project->id) selected @endif>{{ $project->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Document Type</label>
                    <select name="documenttype" class="form-control" size="1">
                        <option value="">Select Document Type</option>
                        @foreach($docTypes as $docType)
                            <option value="{{ $docType->id }}" @if(old('documenttype')==$docType->id) selected @endif>{{ $docType->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="doctitle" class="form-control" value="{{ old('doctitle') }}">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
                <div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
                    <label for="csv_file" class="col-md-4 control-label">File</label>
                    <input id="csv_file" type="file" class="form-control" name="csv_file" required>
                    @if ($errors->has('csv_file'))
                        <span class="help-block">
                            <strong>{{ $errors->first('csv_file') }}</strong>
                        </span>
                    @endif
                </div>

                

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Upload
                                </button>
                            </div>
                        </div>
                </form>
            </div>
    </div>
 @endsection
