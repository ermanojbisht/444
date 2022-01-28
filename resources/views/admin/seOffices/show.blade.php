@extends('layouts.type50.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.seOffice.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.se-offices.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.seOffice.fields.id') }}
                        </th>
                        <td>
                            {{ $seOffice->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seOffice.fields.name') }}
                        </th>
                        <td>
                            {{ $seOffice->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seOffice.fields.name_h') }}
                        </th>
                        <td>
                            {{ $seOffice->name_h }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seOffice.fields.addresss') }}
                        </th>
                        <td>
                            {!! $seOffice->addresss !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seOffice.fields.district') }}
                        </th>
                        <td>
                            {{ $seOffice->district }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seOffice.fields.email_1') }}
                        </th>
                        <td>
                            {{ $seOffice->email_1 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seOffice.fields.email_2') }}
                        </th>
                        <td>
                            {{ $seOffice->email_2 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seOffice.fields.contact_no') }}
                        </th>
                        <td>
                            {{ $seOffice->contact_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seOffice.fields.lat') }}
                        </th>
                        <td>
                            {{ $seOffice->lat }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seOffice.fields.lon') }}
                        </th>
                        <td>
                            {{ $seOffice->lon }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seOffice.fields.ce_office') }}
                        </th>
                        <td>
                            {{ $seOffice->ce_office->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.se-offices.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#se_office_ee_offices" role="tab" data-toggle="tab">
                {{ trans('cruds.eeOffice.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="se_office_ee_offices">
            @includeIf('admin.seOffices.relationships.seOfficeEeOffices', ['eeOffices' => $seOffice->seOfficeEeOffices])
        </div>
    </div>
</div>

@endsection
