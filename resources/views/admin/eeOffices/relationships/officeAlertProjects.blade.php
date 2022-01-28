@can('alert_project_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.alert-projects.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.alertProject.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.alertProject.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-officeAlertProjects">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.alertProject.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.alertProject.fields.alert_for') }}
                        </th>
                        <th>
                            {{ trans('cruds.alertProject.fields.valid_upto') }}
                        </th>
                        <th>
                            {{ trans('cruds.alertProject.fields.refference_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.alertProject.fields.amount') }}
                        </th>
                        <th>
                            {{ trans('cruds.alertProject.fields.valid_from') }}
                        </th>
                        <th>
                            {{ trans('cruds.alertProject.fields.contractor_details') }}
                        </th>
                        <th>
                            {{ trans('cruds.alertProject.fields.project_detail') }}
                        </th>
                        <th>
                            {{ trans('cruds.alertProject.fields.issuing_authority') }}
                        </th>
                        <th>
                            {{ trans('cruds.alertProject.fields.office') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alertProjects as $key => $alertProject)
                        <tr data-entry-id="{{ $alertProject->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $alertProject->id ?? '' }}
                            </td>
                            <td>
                                {{ $alertProject->alert_for->type ?? '' }}
                            </td>
                            <td>
                                {{ $alertProject->valid_upto ?? '' }}
                            </td>
                            <td>
                                {{ $alertProject->refference_no ?? '' }}
                            </td>
                            <td>
                                {{ $alertProject->amount ?? '' }}
                            </td>
                            <td>
                                {{ $alertProject->valid_from ?? '' }}
                            </td>
                            <td>
                                {{ $alertProject->contractor_details ?? '' }}
                            </td>
                            <td>
                                {{ $alertProject->project_detail ?? '' }}
                            </td>
                            <td>
                                {{ $alertProject->issuing_authority ?? '' }}
                            </td>
                            <td>
                                {{ $alertProject->office->name ?? '' }}
                            </td>
                            <td>
                                @can('alert_project_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.alert-projects.show', $alertProject->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('alert_project_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.alert-projects.edit', $alertProject->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('alert_project_delete')
                                    <form action="{{ route('admin.alert-projects.destroy', $alertProject->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('alert_project_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.alert-projects.massDestroy') }}",
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
    order: [[ 3, 'asc' ]],
    pageLength: 25,
  });
  let table = $('.datatable-officeAlertProjects:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection