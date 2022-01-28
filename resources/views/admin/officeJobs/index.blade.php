@extends('layouts.type50.admin')
@section('content')
@can('office_job_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.office-jobs.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.officeJob.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.officeJob.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Permission">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.officeJob.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.officeJob.fields.name') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($OfficeJobs as $key => $OfficeJob)
                        <tr data-entry-id="{{ $OfficeJob->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $OfficeJob->id ?? '' }}
                            </td>
                            <td>
                                {{ $OfficeJob->name ?? '' }}
                            </td>
                            <td>
                                @can('office_job_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.office-jobs.show', $OfficeJob->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('office_job_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.office-jobs.edit', $OfficeJob->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('office_job_delete')
                                    <form action="{{ route('admin.office-jobs.destroy', $OfficeJob->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('office_job_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.office-job.massDestroy') }}",
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
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  });
  let table = $('.datatable-Permission:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
