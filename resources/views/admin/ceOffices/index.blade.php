@extends('layouts.type50.admin')
@section('content')
    @can('ce_office_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.ce-offices.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.ceOffice.title_singular') }}
                </a>
                <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                    {{ trans('global.app_csvImport') }}
                </button>
                @include('csvImport.modal', ['model' => 'CeOffice', 'route' => 'admin.ce-offices.parseCsvImport'])
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.ceOffice.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-CeOffice">
                <thead>
                <tr>
                    <th width="10">
                    </th>
                    <th>
                        {{ trans('cruds.ceOffice.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.ceOffice.fields.name') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                    <th>
                        Office Head
                    </th>
                    <th>
                        {{ trans('cruds.ceOffice.fields.name_h') }}
                    </th>
                    <th>
                        {{ trans('cruds.ceOffice.fields.address') }}
                    </th>
                    <th>
                        {{ trans('cruds.ceOffice.fields.email_1') }}
                    </th>
                    <th>
                        {{ trans('cruds.ceOffice.fields.contact_no') }}
                    </th>
                    <th>
                        {{ trans('cruds.ceOffice.fields.email_2') }}
                    </th>
                    {{--  <th>
                         {{ trans('cruds.ceOffice.fields.lat') }}
                     </th>
                     <th>
                         {{ trans('cruds.ceOffice.fields.lon') }}
                     </th>    --}}
                </tr>
                <tr>
                    <td></td>
                    <td></td>
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
                    {{--  <td>
                         <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                     </td>
                     <td>
                         <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                     </td>   --}}
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
                @can('ce_office_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.ce-offices.massDestroy') }}",
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
                    ajax: "{{ route('admin.ce-offices.index') }}",
                    columns: [
                        {data: 'placeholder', name: 'placeholder'},
                        {data: 'id', name: 'id'},
                        {data: 'name', name: 'name'},
                        {data: 'actions', name: '{{ trans('global.actions') }}'},
                        {data: 'head_emp_code', name: 'head_emp_code'},
                        {data: 'name_h', name: 'name_h'},
                        {data: 'address', name: 'address'},
                        {data: 'email_1', name: 'email_1'},
                        {data: 'contact_no', name: 'contact_no'},
                        {data: 'email_2', name: 'email_2'}
                        /*{ data: 'lat', name: 'lat' },
                        { data: 'lon', name: 'lon' }*/
                    ],
                    orderCellsTop: true,
                    order: [[2, 'asc']],
                    pageLength: 10,
                };
            let table = $('.datatable-CeOffice').DataTable(dtOverrideGlobals);
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
