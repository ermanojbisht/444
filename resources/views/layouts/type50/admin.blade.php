<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.type50._commonpartials._basiccommonheader')
    @include('layouts.type50._commonpartials._fonts')

    {{-- bootstrap4.1.3 --}}
    @include('layouts.type50._commonpartials.css._bootstrap4')
    {{-- datatable.1.10.19 --}}
    @include('layouts._commonpartials.css._datatable')
    {{-- select2 4.0.5 --}}
    @include('layouts._commonpartials.css._select2')
    {{-- datetimepicker --}}
    @include('layouts._commonpartials.css._datetimepicker')
    {{-- dropzone --}}
    @include('layouts._commonpartials.css._dropzone')
    {{-- scrollbar --}}
    @include('layouts._commonpartials.css._scrollbar')
    {{-- coreui --}}
    @include('layouts.type50._commonpartials.css._coreui')

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />

    @yield('styles')
    @yield('headscripts')
</head>

<body class="c-app">
    @include('partials._sidebarmenu')
    <div class="c-wrapper">
        {{-- c-header --}}
        @include('layouts.type50._commonpartials._c_header')
        {{-- c-body --}}
        <div class="c-body">
            <main class="c-main">
                <div class="container-fluid">
                    @include('layouts._commonpartials._alerts_msg')
                    @yield('content')
                </div>
            </main>
            @include('layouts._commonpartials._logoutform')
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    {{-- bootstrap4.1.3 --}}
    @include('layouts.type50._commonpartials.js._bootstrap4')
    {{-- datatable.1.10.19 --}}
    @include('layouts._commonpartials.js._datatable')
    {{-- select2 4.0.5 --}}
    @include('layouts._commonpartials.js._select2')
    {{-- datetimepicker --}}
    @include('layouts._commonpartials.js._datetimepicker')
    {{-- dropzone --}}
    @include('layouts._commonpartials.js._dropzone')
    {{-- scrollbar --}}
    @include('layouts._commonpartials.js._scrollbar')
    {{-- coreui --}}
    @include('layouts.type50._commonpartials.js._coreui')

    <script src="{{ asset('js/main.js') }}"></script>
<script>
$(function() {
  let copyButtonTrans = '{{ trans('global.datatables.copy') }}'
  let csvButtonTrans = '{{ trans('global.datatables.csv') }}'
  let excelButtonTrans = '{{ trans('global.datatables.excel') }}'
  let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
  let printButtonTrans = '{{ trans('global.datatables.print') }}'
  let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}'
  let selectAllButtonTrans = '{{ trans('global.select_all') }}'
  let selectNoneButtonTrans = '{{ trans('global.deselect_all') }}'

  let languages = {
    'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
  };

  $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
  $.extend(true, $.fn.dataTable.defaults, {
    language: {
      url: languages['{{ app()->getLocale() }}']
    },
    columnDefs: [{
        orderable: false,
        className: 'select-checkbox',
        targets: 0
    }, {
        orderable: false,
        searchable: false,
        targets: -1
    }],
    select: {
      style:    'multi+shift',
      selector: 'td:first-child'
    },
    order: [],
    scrollX: true,
    pageLength: 100,
    dom: 'lBfrtip<"actions">',
    buttons: [
      {
        extend: 'selectAll',
        className: 'btn-primary',
        text: selectAllButtonTrans,
        exportOptions: {
          columns: ':visible'
        },
        action: function(e, dt) {
          e.preventDefault()
          dt.rows().deselect();
          dt.rows({ search: 'applied' }).select();
        }
      },
      {
        extend: 'selectNone',
        className: 'btn-primary',
        text: selectNoneButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'copy',
        className: 'btn-default',
        text: copyButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'csv',
        className: 'btn-default',
        text: csvButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'excel',
        className: 'btn-default',
        text: excelButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'pdf',
        className: 'btn-default',
        text: pdfButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'print',
        className: 'btn-default',
        text: printButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'colvis',
        className: 'btn-default',
        text: colvisButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      }
    ]
  });

  $.fn.dataTable.ext.classes.sPageButton = '';
});

</script>
@yield('scripts')
@yield('footscripts')
</body>
</html>
{{-- @foreach(auth()->user()->unreadNotifications as $notification)
        <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
                <div class="preview-icon bg-dark rounded-circle">
                    <i class="mdi mdi-xbox-controller text-success"></i>
                </div>
            </div>
            <div class="preview-item-content">
                <p class="preview-subject mb-1">{{ $notification->data['subject'] }}</p>
                <p class="text-muted ellipsis mb-0">{{ $notification->data['status'] }}</p>
            </div>
        </a>
    @endforeach --}}
    {{--  <div class="row notification-container">
   @forelse(auth()->user()->unreadNotifications  as $notification)
        <div class="col-sm-12" v-for="notification in notifications">
            <div class="alert fade alert-simple alert-success alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show">
                <button type="button" class="close font__size-18" data-dismiss="alert">
                <span aria-hidden="true">
                    <a href="https://www.youtube.com/watch?v=_XiOcsj3oNI&amp;t=50s" target="_blank">
                    <i class="fa fa-times greencross"></i>
                    </a>
                </span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="start-icon far fa-check-circle faa-tada animated"></i>
                {{$notification->data['subject']}}
            </div>
        </div>
    @empty
        No, Notification found!
    @endforelse
</div> --}}
