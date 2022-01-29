<style type="text/css">
    .iconText{
        font-size: 15px;
        font-weight: bold;
        color: white;
    }
    .iconSvg{
        height: 26px;
        width: 26px;
        fill: white; 
        stroke-width: 3;
        stroke-linecap: round;
        stroke-linejoin:  round; 
    }
    .iconlogo{
        width: 100%;
        fill: #88bce8; 
        stroke-width: 3;
        stroke-linecap: round;
        stroke-linejoin:  round; 
    }

</style>

<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            <span class="iconlogo">{!!config('mis_entry.svgIcon')['misentry']!!}</span>
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("employee.home") }}" class="c-sidebar-nav-link">

                <span class="iconSvg">{!!config('mis_entry.svgIcon')['dashboard']!!}</span>
                <span class="iconText">&#160;{{ trans('global.dashboard') }}</span>

                
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <span class="iconSvg">{!!config('mis_entry.svgIcon')['users']!!}</span>
                    <span class="iconText">&#160;{{ trans('cruds.userManagement.title') }}</span>
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('audit_log_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.audit-logs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.auditLog.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('our_office_access')
            <li class="c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.ourOffice.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('ce_office_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.ce-offices.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/ce-offices") || request()->is("admin/ce-offices/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.ceOffice.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('se_office_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.se-offices.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/se-offices") || request()->is("admin/se-offices/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.seOffice.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('ee_office_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.ee-offices.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/ee-offices") || request()->is("admin/ee-offices/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.eeOffice.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        @can('alerts_for_proj_admin_access')
            <li class="c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <span class="iconSvg">{!!config('mis_entry.svgIcon')['alert']!!}</span>
                    <span class="iconText">&#160;{{ trans('cruds.alertsForProjAdmin.title') }}</span>
                </a>
                <ul class="c-sidebar-nav-dropdown-items">

                    @can('office_job_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.office-job-defaults.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/office-job-defaults") || request()->is("admin/office-job-defaults/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-shield-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.officeJobDefault.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('office_job_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.office-jobs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/office-jobs") || request()->is("admin/office-jobs/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-shield-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.officeJob.title') }}
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>
        @endcan





        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            {{-- @can('profile_password_edit') --}}
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            {{-- @endcan --}}
        @endif



        <li class="c-sidebar-nav-item">
            <a href="{{route('myInstances')}}" class="c-sidebar-nav-link" target="_self">
                <span class="iconSvg">{!!config('mis_entry.svgIcon')['estimate']!!}</span>
                <span class="iconText">&#160;Track ACR</span>
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <span class="iconSvg">{!!config('mis_entry.svgIcon')['logout']!!}</span>
                <span class="iconText">&#160;{{ trans('global.logout') }}</span>
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a href="/Font.html" class="c-sidebar-nav-link" target="_blank">
                <span class="iconSvg">{!!config('mis_entry.svgIcon')['fontconvert']!!}</span>
                <span class="iconText">&#160;kruti<->Unicode</span>
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a href="https://www.google.com/intl/hi/inputtools/try/" class="c-sidebar-nav-link" target="_blank">
                <span class="iconSvg">{!!config('mis_entry.svgIcon')['googleInput']!!}</span>
                <span class="iconText">&#160;Google Input Tool</span>                
            </a>
        </li>
    </ul>
    <div class="btn-toolbar p-0" role="toolbar" aria-label="Toolbar with button groups">
      <div class="btn-group m-0" role="group" aria-label="First group">
        <a class="btn btn-warning" href="http://mis.pwduk.in/pwd">
            <span class="iconlogo" style="width:50px; fill: white;">{!!config('mis_entry.svgIcon')['mis']!!}</span>
        </a>
        <a class="btn btn-success" href="http://mis.pwduk.in/im">
            <span class="iconlogo" style="width:50px; fill: white;">{!!config('mis_entry.svgIcon')['im']!!}</span>
        </a>
        <a class="btn btn-warning" href="http://mis.pwduk.in/dms">
            <span class="iconlogo" style="width:50px; fill: white;">{!!config('mis_entry.svgIcon')['dms']!!}</span>
        </a>
        </div>
    </div>
</div>
