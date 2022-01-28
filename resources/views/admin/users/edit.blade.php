@extends('layouts.type50.admin')
@section('content')

@can('user_role_assignment')
<a class="btn btn-warning" href="{{ route('admin.assignUserOffices',['userid'=>$user->id]) }}">

    <div>Edit User Offices <i class="fa-fw fas fa-book">
    </i></div>
</a>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.user.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.users.update", [$user->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
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
                        <input class="form-control {{ $errors->has('name_h') ? 'is-invalid' : '' }}" type="text" name="name_h" id="name_h" value="{{ old('name_h', $user->name_h) }}" required>
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
                        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
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
                        <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password">
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
                        <input class="form-control {{ $errors->has('contact_no') ? 'is-invalid' : '' }}" type="text" name="contact_no" id="contact_no" value="{{ old('contact_no', $user->contact_no) }}" required>
                        @if($errors->has('contact_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('contact_no') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.contact_no_helper') }}</span>
                    </div>
                </div>
                 <div class="col-md-6">
                    {{-- {{chat_id}} --}}
                    <div class="form-group">
                        <label class="" for="chat_id">{{ trans('cruds.user.fields.chat_id') }}</label>
                        <input class="form-control {{ $errors->has('chat_id') ? 'is-invalid' : '' }}" type="text" name="chat_id" id="chat_id" value="{{ old('chat_id', $user->chat_id) }}" >
                        @if($errors->has('chat_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('chat_id') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.chat_id_helper') }} <br>if chat id not avilable then use <strong>10000</strong> as dummy id</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    {{--  Designation text --}}
                    <div class="form-group">
                        <label class="required" for="designation">{{ trans('cruds.user.fields.designation') }}</label>
                        <input class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" type="text" name="designation" id="designation" value="{{ old('designation', $user->designation) }}" required>
                        @if($errors->has('designation'))
                            <div class="invalid-feedback">
                                {{ $errors->first('designation') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.designation_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    {{--  Employee code text --}}
                    <div class="form-group">
                        <label class="" for="emp_code">{{ trans('cruds.user.fields.emp_code') }}</label>
                        <input class="form-control {{ $errors->has('emp_code') ? 'is-invalid' : '' }}" type="text" name="emp_code" id="emp_code" value="{{ old('emp_code', $user->emp_code) }}" >
                        @if($errors->has('emp_code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('emp_code') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.emp_code_helper') }}</span>
                    </div>
                </div>
            </div>
            {{-- approved check box --}}
            <div class="form-group">
                <div class="form-check {{ $errors->has('approved') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="approved" value="0">
                    <input class="form-check-input" type="checkbox" name="approved" id="approved" value="1" {{ $user->approved || old('approved', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="approved">{{ trans('cruds.user.fields.approved') }}</label>
                </div>
                @if($errors->has('approved'))
                    <div class="invalid-feedback">
                        {{ $errors->first('approved') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.approved_helper') }}</span>
            </div>
            {{-- verified check box --}}
            <div class="form-group">
                <div class="form-check {{ $errors->has('verified') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="verified" value="0">
                    <input class="form-check-input" type="checkbox" name="verified" id="verified" value="1" {{ $user->verified || old('verified', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="verified">{{ trans('cruds.user.fields.verified') }}</label>
                </div>
                @if($errors->has('verified'))
                    <div class="invalid-feedback">
                        {{ $errors->first('verified') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.verified_helper') }}</span>
            </div>
            {{-- mkb role --}}
            <div class="form-group">
                <label  for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]" id="roles" multiple >
                    @foreach($roles as $id => $roles)
                        <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || $user->roles->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
                    @endforeach
                </select>
                @if($errors->has('roles'))
                    <div class="invalid-feedback">
                        {{ $errors->first('roles') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
            </div>
            {{-- mkb permission --}}
            <div class="form-group">
                <label for="permissions">{{ trans('cruds.user.fields.permissions') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('permissions') ? 'is-invalid' : '' }}" name="permissions[]" id="permissions" multiple >
                    @foreach($permissions as $id => $permissions)
                        <option value="{{ $id }}" {{ (in_array($id, old('permissions', [])) || $user->permissions->contains($id)) ? 'selected' : '' }}>{{ $permissions }}</option>
                    @endforeach
                </select>
                @if($errors->has('permissions'))
                    <div class="invalid-feedback">
                        {{ $errors->first('permissions') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.permissions_helper') }}</span>
            </div>
            {{--  remark text --}}
            <div class="form-group">
                <label class="" for="remark">{{ trans('cruds.user.fields.remark') }}</label>
                <input class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" type="text" name="remark" id="remark" value="{{ old('remark', $user->remark) }}" >
                @if($errors->has('remark'))
                    <div class="invalid-feedback">
                        {{ $errors->first('remark') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.remark_helper') }}</span>
            </div>
            {{-- mkb submit --}}
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
