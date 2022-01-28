@extends('layouts.type50.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.seOffice.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.se-offices.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.seOffice.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.seOffice.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name_h">{{ trans('cruds.seOffice.fields.name_h') }}</label>
                <input class="form-control {{ $errors->has('name_h') ? 'is-invalid' : '' }}" type="text" name="name_h" id="name_h" value="{{ old('name_h', '') }}">
                @if($errors->has('name_h'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name_h') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.seOffice.fields.name_h_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="addresss">{{ trans('cruds.seOffice.fields.addresss') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('addresss') ? 'is-invalid' : '' }}" name="addresss" id="addresss">{!! old('addresss') !!}</textarea>
                @if($errors->has('addresss'))
                    <div class="invalid-feedback">
                        {{ $errors->first('addresss') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.seOffice.fields.addresss_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="district">{{ trans('cruds.seOffice.fields.district') }}</label>
                <input class="form-control {{ $errors->has('district') ? 'is-invalid' : '' }}" type="number" name="district" id="district" value="{{ old('district', '') }}" step="1">
                @if($errors->has('district'))
                    <div class="invalid-feedback">
                        {{ $errors->first('district') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.seOffice.fields.district_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email_1">{{ trans('cruds.seOffice.fields.email_1') }}</label>
                <input class="form-control {{ $errors->has('email_1') ? 'is-invalid' : '' }}" type="email" name="email_1" id="email_1" value="{{ old('email_1') }}">
                @if($errors->has('email_1'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email_1') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.seOffice.fields.email_1_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email_2">{{ trans('cruds.seOffice.fields.email_2') }}</label>
                <input class="form-control {{ $errors->has('email_2') ? 'is-invalid' : '' }}" type="email" name="email_2" id="email_2" value="{{ old('email_2') }}">
                @if($errors->has('email_2'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email_2') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.seOffice.fields.email_2_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="contact_no">{{ trans('cruds.seOffice.fields.contact_no') }}</label>
                <input class="form-control {{ $errors->has('contact_no') ? 'is-invalid' : '' }}" type="number" name="contact_no" id="contact_no" value="{{ old('contact_no', '') }}" step="1">
                @if($errors->has('contact_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('contact_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.seOffice.fields.contact_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="lat">{{ trans('cruds.seOffice.fields.lat') }}</label>
                <input class="form-control {{ $errors->has('lat') ? 'is-invalid' : '' }}" type="number" name="lat" id="lat" value="{{ old('lat', '') }}" step="0.000001">
                @if($errors->has('lat'))
                    <div class="invalid-feedback">
                        {{ $errors->first('lat') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.seOffice.fields.lat_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="lon">{{ trans('cruds.seOffice.fields.lon') }}</label>
                <input class="form-control {{ $errors->has('lon') ? 'is-invalid' : '' }}" type="number" name="lon" id="lon" value="{{ old('lon', '') }}" step="0.000001">
                @if($errors->has('lon'))
                    <div class="invalid-feedback">
                        {{ $errors->first('lon') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.seOffice.fields.lon_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="ce_office_id">{{ trans('cruds.seOffice.fields.ce_office') }}</label>
                <select class="form-control select2 {{ $errors->has('ce_office') ? 'is-invalid' : '' }}" name="ce_office_id" id="ce_office_id" required>
                    @foreach($ce_offices as $id => $ce_office)
                        <option value="{{ $id }}" {{ old('ce_office_id') == $id ? 'selected' : '' }}>{{ $ce_office }}</option>
                    @endforeach
                </select>
                @if($errors->has('ce_office'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ce_office') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.seOffice.fields.ce_office_helper') }}</span>
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

@section('scripts')
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/admin/se-offices/ckmedia', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', {{ $seOffice->id ?? 0 }});
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

@endsection
