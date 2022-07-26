<style type="text/css">
    .nav-group .nav-item .nav-link::before {
        content: "\2007 \2007 \2007";
    }
</style>

<div class="sidebar sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex p-2">
        <svg class="sidebar-brand-full p-0" width="100%" height="46" alt="PWD Logo" style="fill:powderblue;">
            {!!config('mis_entry.svgIcon')['employee']!!}
        </svg>
        <svg class="sidebar-brand-narrow p-0" width="46" height="46" alt="PWD Logo" style="fill:powderblue;">
            {!!config('mis_entry.svgIcon')['pwd']!!}
        </svg>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <x-nav-item icon="applications" href="{{ route('employee.home') }}">{{ trans('global.dashboard') }}</x-nav-item>
        
        <x-nav-item icon="chat-bubble" href="{{route('employee.index')}}">H R M S</x-nav-item>

        <x-nav-item icon="chat-bubble" href="{{route('employee.hr_grievance')}}">Track Grievance</x-nav-item>
        <x-nav-item icon="badge" href="{{route('acr.myacrs')}}">Track ACR</x-nav-item>
        @if(Auth::check())
            @if(Auth::user()->chat_id <= 10000)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('telegram.connect') }}" target="_blank">
                    <svg class="nav-icon">
                        <use
                            xlink:href="{{url('vendors/@coreui/icons/svg/brand.svg#cib-telegram-plane')}}">
                        </use>
                    </svg>
                    <span>Telegtam Integeration</span>
                </a>
            </li>
            @endif
        @endif
        @can('user_management_access')
            <x-nav-group icon="user-plus" name="{{ trans('cruds.userManagement.title') }}">
                @can('permission_access')
                    <x-nav-item icon="media-record" href="{{ route('admin.permissions.index') }}">{{ trans('cruds.permission.title') }}</x-nav-item>
                @endcan
                @can('role_access')
                    <x-nav-item icon="media-record" href='{{ route("admin.roles.index") }}'>{{ trans('cruds.role.title') }}</x-nav-item>
                @endcan
                @can('user_access')
                    <x-nav-item icon="media-record" href='{{ route("admin.users.index") }}'>{{ trans('cruds.user.title') }}</x-nav-item>
                @endcan
            </x-nav-group>
        @endcan
        @can('our_office_access')
            <x-nav-group icon="sitemap" name="{{ trans('cruds.ourOffice.title') }}">
                @can('ce_office_access')
                    <x-nav-item icon="media-record" href="{{ route('admin.ce-offices.index') }}">{{ trans('cruds.ceOffice.title') }}</x-nav-item>
                @endcan
                @can('se_office_access')
                    <x-nav-item icon="media-record" href="{{ route('admin.se-offices.index') }}">{{ trans('cruds.seOffice.title') }}</x-nav-item>
                @endcan
                @can('ee_office_access')
                    <x-nav-item icon="media-record" href="{{ route('admin.ee-offices.index') }}">{{ trans('cruds.eeOffice.title') }}</x-nav-item>
                @endcan
            </x-nav-group>  
        @endcan
        {{-- @can('office_job_access')
            <x-nav-group icon="bell-exclamation" name="Jobs">
                <x-nav-item icon="media-record" href="{{route('admin.office-jobs.index')}}">{{ trans('cruds.officeJob.title') }}</x-nav-item>
                <x-nav-item icon="media-record" href="{{route('admin.office-job-defaults.index')}}">{{ trans('cruds.officeJobDefault.title') }}</x-nav-item>
                @can('audit_log_access')
                    <x-nav-item icon="media-record" href="{{route('admin.audit-logs.index')}}">{{ trans('cruds.auditLog.title') }}</x-nav-item>
                @endcan
            </x-nav-group>
        @endcan --}}
        
        {{-- At Bottom --}}
        {{-- <li class="nav-title mt-auto">Tools For Hindi Typing</li>
        <li class="nav-item ">
            <x-nav-item icon="language" href="{{url('../Font.html')}}" target="_blank" >KurtiDev to Unicode</x-nav-item>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="https://www.google.com/intl/hi/inputtools/try/" target="_blank">
                <svg class="nav-icon">
                    <use
                        xlink:href="{{url('vendors/@coreui/icons/svg/brand.svg#cib-google')}}">
                    </use>
                </svg>
                <span>Google Hindi Input</span>
            </a>
        </li> --}}
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
