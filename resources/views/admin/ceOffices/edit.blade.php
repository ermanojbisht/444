@extends('layouts.type50.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.ceOffice.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.ce-offices.update", [$ceOffice->id]) }}"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.ceOffice.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                           id="name" value="{{ old('name', $ceOffice->name) }}" required>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.ceOffice.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="name_h">{{ trans('cruds.ceOffice.fields.name_h') }}</label>
                    <input class="form-control {{ $errors->has('name_h') ? 'is-invalid' : '' }}" type="text"
                           name="name_h" id="name_h" value="{{ old('name_h', $ceOffice->name_h) }}" required>
                    @if($errors->has('name_h'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name_h') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.ceOffice.fields.name_h_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="address">{{ trans('cruds.ceOffice.fields.address') }}</label>
                    <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text"
                           name="address" id="address" value="{{ old('address', $ceOffice->address) }}">
                    @if($errors->has('address'))
                        <div class="invalid-feedback">
                            {{ $errors->first('address') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.ceOffice.fields.address_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="district">{{ trans('cruds.ceOffice.fields.district') }}</label>
                    <input class="form-control {{ $errors->has('district') ? 'is-invalid' : '' }}" type="number"
                           name="district" id="district" value="{{ old('district', $ceOffice->district) }}" step="1">
                    @if($errors->has('district'))
                        <div class="invalid-feedback">
                            {{ $errors->first('district') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.ceOffice.fields.district_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="email_1">{{ trans('cruds.ceOffice.fields.email_1') }}</label>
                    <input class="form-control {{ $errors->has('email_1') ? 'is-invalid' : '' }}" type="email"
                           name="email_1" id="email_1" value="{{ old('email_1', $ceOffice->email_1) }}">
                    @if($errors->has('email_1'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email_1') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.ceOffice.fields.email_1_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="contact_no">{{ trans('cruds.ceOffice.fields.contact_no') }}</label>
                    <input class="form-control {{ $errors->has('contact_no') ? 'is-invalid' : '' }}" type="number"
                           name="contact_no" id="contact_no" value="{{ old('contact_no', $ceOffice->contact_no) }}"
                           step="1">
                    @if($errors->has('contact_no'))
                        <div class="invalid-feedback">
                            {{ $errors->first('contact_no') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.ceOffice.fields.contact_no_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="email_2">{{ trans('cruds.ceOffice.fields.email_2') }}</label>
                    <input class="form-control {{ $errors->has('email_2') ? 'is-invalid' : '' }}" type="email"
                           name="email_2" id="email_2" value="{{ old('email_2', $ceOffice->email_2) }}">
                    @if($errors->has('email_2'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email_2') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.ceOffice.fields.email_2_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="lat">{{ trans('cruds.ceOffice.fields.lat') }}</label>
                    <input class="form-control {{ $errors->has('lat') ? 'is-invalid' : '' }}" type="number" name="lat"
                           id="lat" value="{{ old('lat', $ceOffice->lat) }}" step="0.000001">
                    @if($errors->has('lat'))
                        <div class="invalid-feedback">
                            {{ $errors->first('lat') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.ceOffice.fields.lat_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="lon">{{ trans('cruds.ceOffice.fields.lon') }}</label>
                    <input class="form-control {{ $errors->has('lon') ? 'is-invalid' : '' }}" type="number" name="lon"
                           id="lon" value="{{ old('lon', $ceOffice->lon) }}" step="0.000001">
                    @if($errors->has('lon'))
                        <div class="invalid-feedback">
                            {{ $errors->first('lon') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.ceOffice.fields.lon_helper') }}</span>
                </div>
                {{-- head_emp_code --}}
                <div class="form-group col-md-6">
                    <label class="required" for="head_emp_code">Office Head</label>
                    <select class="form-control select2 {{ $errors->has('head_emp_code') ? 'is-invalid' : '' }}"
                            name="head_emp_code" id="head_emp_code" required>
                    </select>
                    @if($errors->has('head_emp_code'))
                        <div class="invalid-feedback">
                            {{ $errors->first('head_emp_code') }}
                        </div>
                    @endif
                    <span class="help-block">Select office head</span>
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
// CSRF Token

            var _token = $('input[name="_token"]').val();
            $('#head_emp_code').select2({
                minimumInputLength: 3,
                placeholder: 'Select an Employess as head',
                ajax: {
                    url: "{{ route('dynamicdependent') }}",

                    method: "POST",
                    data: function (params) {
                        return {
                            _token: _token,
                            term: params.term,// search term
                            dependent: 'employee_id'
                        };
                    },

                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.name + ":" + item.id,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
            var empSelected = $('#head_emp_code');
            var data1 = {text: "{{$ceOffice->officeHead->nameemp??''}}", id: "{{$ceOffice->head_emp_code}}",}
            var option = new Option(data1.text, data1.text.id, true, true);
            empSelected.append(option).trigger('change');

        });
    </script>
@endsection
