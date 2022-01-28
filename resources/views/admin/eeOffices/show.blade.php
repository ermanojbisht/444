@extends('layouts.type50.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.eeOffice.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ee-offices.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                      <tr>
                        <th>
                            IS Exist
                        </th>
                        <td>
                            {{ $eeOffice->is_exist?"Yes":"No" }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eeOffice.fields.id') }}
                        </th>
                        <td>
                            {{ $eeOffice->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eeOffice.fields.name') }}
                        </th>
                        <td>
                            {{ $eeOffice->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eeOffice.fields.name_h') }}
                        </th>
                        <td>
                            {{ $eeOffice->name_h }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eeOffice.fields.addresss') }}
                        </th>
                        <td>
                            {!! $eeOffice->addresss !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eeOffice.fields.district') }}
                        </th>
                        <td>
                            {{ $eeOffice->district }}
                        </td>
                    </tr>
                     <tr>
                        <th>
                            Tressury code : DDO code
                        </th>
                        <td>
                            {{ $eeOffice->tressury_code }}:{{ $eeOffice->ddo_code }}
                        </td>
                    </tr>
                     <tr>
                        <th>
                            Office Head
                        </th>
                        <td>
                           {{$eeOffice->officeHead->name ?? 'Not Known' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                           Email
                        </th>
                        <td>
                            {{ $eeOffice->email }}<br>{{ $eeOffice->email_2 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eeOffice.fields.contact_no') }}
                        </th>
                        <td>
                            {{ $eeOffice->contact_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Location
                        </th>
                        <td>
                            {{ $eeOffice->lat }},{{ $eeOffice->lon }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eeOffice.fields.se_office') }}
                        </th>
                        <td>
                            {{ $eeOffice->se_office->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ee-offices.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>
{{-- <div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#office_alert_projects" role="tab" data-toggle="tab">
                {{ trans('cruds.alertProject.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#division_road_divs" role="tab" data-toggle="tab">
                {{ trans('cruds.roadDiv.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="office_alert_projects">
            @includeIf('admin.eeOffices.relationships.officeAlertProjects', ['alertProjects' => $eeOffice->officeAlertProjects])
        </div>
        <div class="tab-pane" role="tabpanel" id="division_road_divs">
            @includeIf('admin.eeOffices.relationships.divisionRoadDivs', ['roadDivs' => $eeOffice->divisionRoadDivs])
        </div>
    </div>
</div> --}}

@endsection
