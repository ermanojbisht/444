@extends('layouts.type50.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Update Your email address
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("profile.email.update") }}">
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.user.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required>
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>           
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
            <div>
                Mail Should be unique.
            </div>
        </form>
    </div>
</div>

@endsection
