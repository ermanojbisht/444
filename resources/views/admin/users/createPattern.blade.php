@extends('layouts.type50.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} Work Pattern for Telegram Notifications
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.storeWorkPatternForTelegram") }}" encWORK_code="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="WORK_code">WORK Code Pattern</label>
                <input class="form-control {{ $errors->has('WORK_code') ? 'is-invalid' : '' }}" WORK_code="text" name="WORK_code" id="WORK_code" value="{{ old('WORK_code', '') }}" required>
                @if($errors->has('WORK_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('WORK_code') }}
                    </div>
                @endif
                <span class="help-block"></span>
            </div>
            <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
            <div class="form-group">
                <button class="btn btn-danger" WORK_code="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
