@extends('layouts.type50.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.ceOffice.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ce-offices.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.ceOffice.fields.id') }}
                        </th>
                        <td>
                            {{ $ceOffice->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ceOffice.fields.name') }}
                        </th>
                        <td>
                            {{ $ceOffice->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ceOffice.fields.name_h') }}
                        </th>
                        <td>
                            {{ $ceOffice->name_h }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ceOffice.fields.address') }}
                        </th>
                        <td>
                            {{ $ceOffice->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ceOffice.fields.district') }}
                        </th>
                        <td>
                            {{ $ceOffice->district }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ceOffice.fields.email_1') }}
                        </th>
                        <td>
                            {{ $ceOffice->email_1 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ceOffice.fields.contact_no') }}
                        </th>
                        <td>
                            {{ $ceOffice->contact_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ceOffice.fields.email_2') }}
                        </th>
                        <td>
                            {{ $ceOffice->email_2 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ceOffice.fields.lat') }}
                        </th>
                        <td>
                            {{ $ceOffice->lat }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ceOffice.fields.lon') }}
                        </th>
                        <td>
                            {{ $ceOffice->lon }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ce-offices.index') }}">
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
            <a class="nav-link" href="#ce_office_se_offices" role="tab" data-toggle="tab">
                {{ trans('cruds.seOffice.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="ce_office_se_offices">
            @includeIf('admin.ceOffices.relationships.ceOfficeSeOffices', ['seOffices' => $ceOffice->ceOfficeSeOffices])
        </div>
    </div>
</div>

@endsection
