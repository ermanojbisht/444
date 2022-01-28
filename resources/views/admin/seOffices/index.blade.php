@extends('layouts.type50.admin')
@section('content')
    @can('se_office_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.se-offices.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.seOffice.title_singular') }}
                </a>
                <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                    {{ trans('global.app_csvImport') }}
                </button>
                @include('csvImport.modal', ['model' => 'SeOffice', 'route' => 'admin.se-offices.parseCsvImport'])
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.seOffice.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-SeOffice">
                <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.seOffice.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.seOffice.fields.name') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                    <th>Office head</th>
                    <th>
                        {{ trans('cruds.seOffice.fields.name_h') }}
                    </th>
                    <th>
                        {{ trans('cruds.seOffice.fields.email_1') }}
                    </th>
                    <th>
                        {{ trans('cruds.seOffice.fields.email_2') }}
                    </th>
                    <th>
                        {{ trans('cruds.seOffice.fields.contact_no') }}
                    </th>
                    <th>
                        {{ trans('cruds.seOffice.fields.lat') }}
                    </th>
                    <th>
                        {{ trans('cruds.seOffice.fields.lon') }}
                    </th>
                    <th>
                        {{ trans('cruds.seOffice.fields.ce_office') }}
                    </th>

                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td></td>
                    <td></td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($ce_offices as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                </thead>
            </table>
        </div>
    </div>



@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
                @can('se_office_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.se-offices.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({selected: true}).data(), function (entry) {
                        return entry.id
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: {ids: ids, _method: 'DELETE'}
                        })
                            .done(function () {
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)
                @endcan

            let dtOverrideGlobals = {
                    buttons: dtButtons,
                    processing: true,
                    serverSide: true,
                    retrieve: true,
                    aaSorting: [],
                    ajax: "{{ route('admin.se-offices.index') }}",
                    columns: [
                        {data: 'placeholder', name: 'placeholder'},
                        {data: 'id', name: 'id'},
                        {data: 'name', name: 'name'},
                        {data: 'actions', name: '{{ trans('global.actions') }}'},
                        {data: 'head_emp_code', name: 'head_emp_code'},
                        {data: 'name_h', name: 'name_h'},
                        {data: 'email_1', name: 'email_1'},
                        {data: 'email_2', name: 'email_2'},
                        {data: 'contact_no', name: 'contact_no'},
                        {data: 'lat', name: 'lat'},
                        {data: 'lon', name: 'lon'},
                        {data: 'ce_office_name', name: 'ce_office.name'}

                    ],
                    orderCellsTop: true,
                    order: [[2, 'asc']],
                    pageLength: 10,
                };
            let table = $('.datatable-SeOffice').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
            $('.datatable thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw()
            });
        });

    </script>
@endsection
