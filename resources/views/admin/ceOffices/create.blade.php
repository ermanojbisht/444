@extends('layouts.type50.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.ceOffice.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.ce-offices.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.ceOffice.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.ceOffice.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name_h">{{ trans('cruds.ceOffice.fields.name_h') }}</label>
                <input class="form-control {{ $errors->has('name_h') ? 'is-invalid' : '' }}" type="text" name="name_h" id="name_h" value="{{ old('name_h', '') }}" required>
                @if($errors->has('name_h'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name_h') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.ceOffice.fields.name_h_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.ceOffice.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', '') }}">
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.ceOffice.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="district">{{ trans('cruds.ceOffice.fields.district') }}</label>
                <input class="form-control {{ $errors->has('district') ? 'is-invalid' : '' }}" type="number" name="district" id="district" value="{{ old('district', '') }}" step="1">
                @if($errors->has('district'))
                    <div class="invalid-feedback">
                        {{ $errors->first('district') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.ceOffice.fields.district_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email_1">{{ trans('cruds.ceOffice.fields.email_1') }}</label>
                <input class="form-control {{ $errors->has('email_1') ? 'is-invalid' : '' }}" type="email" name="email_1" id="email_1" value="{{ old('email_1') }}">
                @if($errors->has('email_1'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email_1') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.ceOffice.fields.email_1_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="contact_no">{{ trans('cruds.ceOffice.fields.contact_no') }}</label>
                <input class="form-control {{ $errors->has('contact_no') ? 'is-invalid' : '' }}" type="number" name="contact_no" id="contact_no" value="{{ old('contact_no', '') }}" step="1">
                @if($errors->has('contact_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('contact_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.ceOffice.fields.contact_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email_2">{{ trans('cruds.ceOffice.fields.email_2') }}</label>
                <input class="form-control {{ $errors->has('email_2') ? 'is-invalid' : '' }}" type="email" name="email_2" id="email_2" value="{{ old('email_2') }}">
                @if($errors->has('email_2'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email_2') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.ceOffice.fields.email_2_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="lat">{{ trans('cruds.ceOffice.fields.lat') }}</label>
                <input class="form-control {{ $errors->has('lat') ? 'is-invalid' : '' }}" type="number" name="lat" id="lat" value="{{ old('lat', '') }}" step="0.000001">
                @if($errors->has('lat'))
                    <div class="invalid-feedback">
                        {{ $errors->first('lat') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.ceOffice.fields.lat_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="lon">{{ trans('cruds.ceOffice.fields.lon') }}</label>
                <input class="form-control {{ $errors->has('lon') ? 'is-invalid' : '' }}" type="number" name="lon" id="lon" value="{{ old('lon', '') }}" step="0.000001">
                @if($errors->has('lon'))
                    <div class="invalid-feedback">
                        {{ $errors->first('lon') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.ceOffice.fields.lon_helper') }}</span>
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
