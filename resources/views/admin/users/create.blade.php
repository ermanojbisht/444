@extends('layouts.type50.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.users.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="name_h">{{ trans('cruds.user.fields.name_h') }}</label>
                        <input class="form-control {{ $errors->has('name_h') ? 'is-invalid' : '' }}" type="text" name="name_h" id="name_h" value="{{ old('name_h', '') }}" required>
                        @if($errors->has('name_h'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name_h') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.name_h_helper') }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}" required>
                        @if($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                        <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" required>
                        @if($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    {{--  Contact No text --}}
                    <div class="form-group">
                        <label class="required" for="contact_no">{{ trans('cruds.user.fields.contact_no') }}</label>
                        <input class="form-control {{ $errors->has('contact_no') ? 'is-invalid' : '' }}" type="text" name="contact_no" id="contact_no" value="{{ old('contact_no', '') }}" required>
                        @if($errors->has('contact_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('contact_no') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.contact_no_helper') }}</span>
                    </div>
                </div>
                {{--  chat_id text --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="" for="chat_id">{{ trans('cruds.user.fields.chat_id') }}</label>
                        <input class="form-control {{ $errors->has('chat_id') ? 'is-invalid' : '' }}" type="text" name="chat_id" id="chat_id" value="{{ old('chat_id', '') }}" >
                        @if($errors->has('chat_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('chat_id') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.chat_id_helper') }}<br>if chat id not avilable then use <strong>10000</strong> as dummy id</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    {{--  Employee code text --}}
                    <div class="form-group">
                        <label class="required" for="employee_id">{{ trans('cruds.user.fields.emp_code') }}</label>
                        <input class="form-control {{ $errors->has('employee_id') ? 'is-invalid' : '' }}" type="text" name="employee_id" id="employee_id" value="{{ old('employee_id', '') }}" required>
                        @if($errors->has('employee_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('employee_id') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.emp_code_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-6">

                </div>
            </div>
            {{-- approved check box --}}
            <div class="form-group">
                <div class="form-check {{ $errors->has('approved') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="approved" value="0">
                    <input class="form-check-input" type="checkbox" name="approved" id="approved" value="1" {{ old('approved', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="approved">{{ trans('cruds.user.fields.approved') }}</label>
                </div>
                @if($errors->has('approved'))
                    <div class="invalid-feedback">
                        {{ $errors->first('approved') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.approved_helper') }}</span>
            </div>
            {{-- roles multiple select2--}}
            <div class="form-group">
                <label class="" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]" id="roles" multiple >
                    @foreach($roles as $id => $roles)
                        <option value="{{ $id }}" {{ in_array($id, old('roles', [])) ? 'selected' : '' }}>{{ $roles }}</option>
                    @endforeach
                </select>
                @if($errors->has('roles'))
                    <div class="invalid-feedback">
                        {{ $errors->first('roles') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
            </div>
            {{--  remark text --}}
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
