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
                <label class="required" for="office_id">Office</label>
                <select class="form-control select2 {{ $errors->has('office_id') ? 'is-invalid' : '' }}" name="office_id" id="office_id" required>
                    <option value="" >Please select</option>
                    @foreach($offices as $id => $office)
                        <option value="{{ $office->id }}" {{ old('office_id') == $office->id ? 'selected' : '' }}>{{ $office->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('office_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('office_id') }}
                    </div>
                @endif
                <span class="help-block">Office</span>
            </div>
            <div class="form-group">
                <label class="required" for="user_id">Name Of User</label>
                <select class="form-control select2 {{ $errors->has('user_id') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    <option value="" >Please select</option>
                    @foreach($users as $id => $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} : {{$user->employee_id}}</option>
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
