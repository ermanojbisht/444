@extends('layouts.type50.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.eeOffice.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.ee-offices.update", [$eeOffice->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
            {{-- name --}}
            <div class="form-group col-md-4">
                <label class="required" for="name">{{ trans('cruds.eeOffice.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $eeOffice->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eeOffice.fields.name_helper') }}</span>
            </div>
            {{-- name hindi--}}
            <div class="form-group  col-md-4">
                <label for="name_h">{{ trans('cruds.eeOffice.fields.name_h') }}</label>
                <input class="form-control {{ $errors->has('name_h') ? 'is-invalid' : '' }}" type="text" name="name_h" id="name_h" value="{{ old('name_h', $eeOffice->name_h) }}">
                @if($errors->has('name_h'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name_h') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eeOffice.fields.name_h_helper') }}</span>
            </div>
            {{-- district --}}
            <div class="form-group col-md-4">
                <label for="district">Jurdiction District</label>
                <input class="form-control {{ $errors->has('district') ? 'is-invalid' : '' }}" type="text" name="district" id="district" value="{{ old('district', $eeOffice->district) }}" step="1">
                @if($errors->has('district'))
                    <div class="invalid-feedback">
                        {{ $errors->first('district') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eeOffice.fields.district_helper') }}</span>
            </div>
            </div>
             <div class="row">
            <div class="form-group col-md-6">
                <label class="required" for="se_office_id">{{ trans('cruds.eeOffice.fields.se_office') }}</label>
                <select class="form-control select2 {{ $errors->has('se_office') ? 'is-invalid' : '' }}" name="se_office_id" id="se_office_id" required>
                    @foreach($se_offices as $id => $se_office)
                        <option value="{{ $id }}" {{ (old('se_office_id') ? old('se_office_id') : $eeOffice->se_office->id ?? '') == $id ? 'selected' : '' }}>{{ $se_office }}</option>
                    @endforeach
                </select>
                @if($errors->has('se_office'))
                    <div class="invalid-feedback">
                        {{ $errors->first('se_office') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eeOffice.fields.se_office_helper') }}</span>
            </div>
            {{-- head_emp_code --}}
            <div class="form-group col-md-6" id="hrms-model">
                <label class="required" for="head_emp_code">Office Head</label>
                <select class="form-control select2 {{ $errors->has('head_emp_code') ? 'is-invalid' : '' }}" name="head_emp_code" id="head_emp_code" required>
                </select>
                @if($errors->has('head_emp_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('head_emp_code') }}
                    </div>
                @endif
                <span class="help-block">Select office head</span>
            </div>
            </div>
            Contact Details
            <div class="row">
            <div class="form-group col-md-4">
                <label for="email">Email</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $eeOffice->email) }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>
            <div class="form-group col-md-4">
                <label for="email_2">{{ trans('cruds.eeOffice.fields.email_2') }}</label>
                <input class="form-control {{ $errors->has('email_2') ? 'is-invalid' : '' }}" type="email" name="email_2" id="email_2" value="{{ old('email_2', $eeOffice->email_2) }}">
                @if($errors->has('email_2'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email_2') }}
                    </div>
                @endif
            </div>
            <div class="form-group col-md-4">
                <label for="contact_no">{{ trans('cruds.eeOffice.fields.contact_no') }}</label>
                <input class="form-control {{ $errors->has('contact_no') ? 'is-invalid' : '' }}" type="number" name="contact_no" id="contact_no" value="{{ old('contact_no', $eeOffice->contact_no) }}" step="1">
                @if($errors->has('contact_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('contact_no') }}
                    </div>
                @endif
            </div>
            Location
            </div>
            <div class="row">
            <div class="form-group col-md-6">
                <label for="lat">{{ trans('cruds.eeOffice.fields.lat') }}</label>
                <input class="form-control {{ $errors->has('lat') ? 'is-invalid' : '' }}" type="number" name="lat" id="lat" value="{{ old('lat', $eeOffice->lat) }}" step="0.00000001">
                @if($errors->has('lat'))
                    <div class="invalid-feedback">
                        {{ $errors->first('lat') }}
                    </div>
                @endif
            </div>
            <div class="form-group col-md-6">
                <label for="lon">{{ trans('cruds.eeOffice.fields.lon') }}</label>
                <input class="form-control {{ $errors->has('lon') ? 'is-invalid' : '' }}" type="number" name="lon" id="lon" value="{{ old('lon', $eeOffice->lon) }}" step="0.00000001">
                @if($errors->has('lon'))
                    <div class="invalid-feedback">
                        {{ $errors->first('lon') }}
                    </div>
                @endif
            </div>
            </div>
             {{-- address --}}
            <div class="form-group">
                <label for="addresss">{{ trans('cruds.eeOffice.fields.addresss') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('addresss') ? 'is-invalid' : '' }}" name="addresss" id="addresss">{!! old('addresss', $eeOffice->addresss) !!}</textarea>
                @if($errors->has('addresss'))
                    <div class="invalid-feedback">
                        {{ $errors->first('addresss') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eeOffice.fields.addresss_helper') }}</span>
            </div>
           {{-- is_exist check box --}}
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_exist') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_exist" value="0">
                    <input class="form-check-input" type="checkbox" name="is_exist" id="is_exist" value="1" {{ $eeOffice->is_exist || old('is_exist', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_exist">Is Exist</label>
                </div>
                @if($errors->has('is_exist'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_exist') }}
                    </div>
                @endif
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
    @include('partials.js._employeeSelect2DropDownJs')
    $(document).ready(function () {
  /*function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/admin/ee-offices/ckmedia', true);
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
                data.append('crud_id', {{ $eeOffice->id ?? 0 }});
                xhr.send(data);
              });
            })
        }
      };
    }
  }*/

/*  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }*/
  // CSRF Token

employeeSelect2DropDown('#head_emp_code',minimumInputLength=3,employeeType='er',section='All',removeLogged='false');

let empSelected = $('#head_emp_code');
let data1={text:"{{$eeOffice->officeHead->nameemp??''}}",id:"{{$eeOffice->head_emp_code}}",}
let option = new Option(data1.text, data1.text.id, true, true);
empSelected.append(option).trigger('change');

});
</script>

@endsection
