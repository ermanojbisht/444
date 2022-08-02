@extends('layouts.type50.admin')
@section('content')

@can('user_role_assignment')
<a class="btn btn-warning" href="{{ route('admin.assignUserOffices',['userid'=>$employee->id]) }}">

    <div>Edit PIC to view <i class="fa-fw fas fa-book">
    </i></div>
</a>
@endcan
<div class="card">
    <div class="card-header">
        Edit Employee {{$employee->name}}, Mail: {{$employee->email}}, Mobile No: {{$employee->phone_no}}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.employee.update", [$employee->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-6">
                    {{--  Contact No text --}}
                    <div class="form-group">
                        <label class="required" for="phone_no">{{ trans('cruds.user.fields.contact_no') }}</label>
                        <input class="form-control {{ $errors->has('phone_no') ? 'is-invalid' : '' }}" type="text" name="phone_no" id="phone_no" value="{{ old('phone_no', $employee->phone_no) }}" required>
                        @if($errors->has('phone_no'))
                            <div class="invalid-feedback">
                                {{ $errors->first('phone_no') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.contact_no_helper') }}</span>
                    </div>
                </div>
                 <div class="col-md-6">
                    {{-- {{chat_id}} --}}
                    <div class="form-group">
                        <label class="" for="chat_id">{{ trans('cruds.user.fields.chat_id') }}</label>
                        <input class="form-control {{ $errors->has('chat_id') ? 'is-invalid' : '' }}" type="text" name="chat_id" id="chat_id" value="{{ old('chat_id', $employee->chat_id) }}" >
                        @if($errors->has('chat_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('chat_id') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.chat_id_helper') }} </span>
                    </div>
                </div>
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
