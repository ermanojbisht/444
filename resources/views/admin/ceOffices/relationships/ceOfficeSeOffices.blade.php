@can('se_office_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.se-offices.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.seOffice.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.seOffice.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-ceOfficeSeOffices">
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
                            {{ trans('cruds.seOffice.fields.name_h') }}
                        </th>
                        <th>
                            {{ trans('cruds.seOffice.fields.district') }}
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
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($seOffices as $key => $seOffice)
                        <tr data-entry-id="{{ $seOffice->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $seOffice->id ?? '' }}
                            </td>
                            <td>
                                {{ $seOffice->name ?? '' }}
                            </td>
                            <td>
                                {{ $seOffice->name_h ?? '' }}
                            </td>
                            <td>
                                {{ $seOffice->district ?? '' }}
                            </td>
                            <td>
                                {{ $seOffice->email_1 ?? '' }}
                            </td>
                            <td>
                                {{ $seOffice->email_2 ?? '' }}
                            </td>
                            <td>
                                {{ $seOffice->contact_no ?? '' }}
                            </td>
                            <td>
                                {{ $seOffice->lat ?? '' }}
                            </td>
                            <td>
                                {{ $seOffice->lon ?? '' }}
                            </td>
                            <td>
                                {{ $seOffice->ce_office->name ?? '' }}
                            </td>
                            <td>
                                @can('se_office_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.se-offices.show', $seOffice->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('se_office_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.se-offices.edit', $seOffice->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('se_office_delete')
                                    <form action="{{ route('admin.se-offices.destroy', $seOffice->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('se_office_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.se-offices.massDestroy') }}",
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
  let table = $('.datatable-ceOfficeSeOffices:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection