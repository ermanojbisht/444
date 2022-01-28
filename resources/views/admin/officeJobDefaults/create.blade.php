@extends('layouts.type50.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Add a user to a job for a particular office
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.office-job-defaults.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="job_id">Job Type</label>
                 <select class="form-control select2 {{ $errors->has('job_id') ? 'is-invalid' : '' }}" name="job_id" id="job_id" required>
                    @foreach($jobs as $id => $job)
                        <option value="{{ $id }}" {{ old('job_id') == $id ? 'selected' : '' }}>{{ $job }}</option>
                    @endforeach
                </select>
                @if($errors->has('job_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('job_id') }}
                    </div>
                @endif
                <span class="help-block">JOB ID</span>
            </div>
            <div class="form-group">
                <label class="required" for="ee_office_id">EE Office</label>
                <select class="form-control select2 {{ $errors->has('ee_office_id') ? 'is-invalid' : '' }}" name="ee_office_id" id="ee_office_id" required>
                    <option value="" >Please select</option>
                    @foreach($offices as $id => $office)
                        <option value="{{ $office->id }}" {{ old('ee_office_id') == $office->id ? 'selected' : '' }}>{{ $office->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('ee_office_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ee_office_id') }}
                    </div>
                @endif
                <span class="help-block">EE Office ID</span>
            </div>
            <div class="form-group">
                <label class="required" for="user_id">Name Of User</label>
                <select class="form-control select2 {{ $errors->has('user_id') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    <option value="" >Please select</option>
                    @foreach($users as $id => $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('user_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user_id') }}
                    </div>
                @endif
                <span class="help-block">User Id</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
