@can('ee_office_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.ee-offices.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.eeOffice.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.eeOffice.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-seOfficeEeOffices">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.eeOffice.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.eeOffice.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.eeOffice.fields.name_h') }}
                        </th>
                        <th>
                            {{ trans('cruds.eeOffice.fields.district') }}
                        </th>
                        <th>
                            {{ trans('cruds.eeOffice.fields.email_1') }}
                        </th>
                        <th>
                            {{ trans('cruds.eeOffice.fields.email_2') }}
                        </th>
                        <th>
                            {{ trans('cruds.eeOffice.fields.contact_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.eeOffice.fields.lat') }}
                        </th>
                        <th>
                            {{ trans('cruds.eeOffice.fields.lon') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eeOffices as $key => $eeOffice)
                        <tr data-entry-id="{{ $eeOffice->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $eeOffice->id ?? '' }}
                            </td>
                            <td>
                                {{ $eeOffice->name ?? '' }}
                            </td>
                            <td>
                                {{ $eeOffice->name_h ?? '' }}
                            </td>
                            <td>
                                {{ $eeOffice->district ?? '' }}
                            </td>
                            <td>
                                {{ $eeOffice->email_1 ?? '' }}
                            </td>
                            <td>
                                {{ $eeOffice->email_2 ?? '' }}
                            </td>
                            <td>
                                {{ $eeOffice->contact_no ?? '' }}
                            </td>
                            <td>
                                {{ $eeOffice->lat ?? '' }}
                            </td>
                            <td>
                                {{ $eeOffice->lon ?? '' }}
                            </td>
                            <td>
                                @can('ee_office_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.ee-offices.show', $eeOffice->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('ee_office_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.ee-offices.edit', $eeOffice->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('ee_office_delete')
                                    <form action="{{ route('admin.ee-offices.destroy', $eeOffice->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('ee_office_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.ee-offices.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
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
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 2, 'asc' ]],
    pageLength: 10,
  });
  let table = $('.datatable-seOfficeEeOffices:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection