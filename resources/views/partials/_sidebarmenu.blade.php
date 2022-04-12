<style type="text/css">
    .iconText{
        font-size: 12px;
        color: white;
    }
    .iconlogo{
        fill: #88bce8; 
    }

</style>

<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full p-3" href="#">
            <span class="iconlogo">{!!config('mis_entry.svgIcon')['employee']!!}</span>
        </a>
    </div>
    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("employee.home") }}" class="c-sidebar-nav-link">
                <i class="fa fa-vcard c-sidebar-nav-icon"> </i>
                <span class="iconText">&#160;{{ trans('global.dashboard') }}</span>
            </a>
        </li>       
        @canany(['user_management_access','asset_access'])
            <li class="c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa fa-users fa-key c-sidebar-nav-icon"> </i>
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
                    @canany(['user_access','asset_access'])
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
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
                    <span class="iconText">{{ trans('cruds.ourOffice.title') }}</span>
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('ce_office_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.ce-offices.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/ce-offices") || request()->is("admin/ce-offices/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                <span class="iconText">{{ trans('cruds.ceOffice.title') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('se_office_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.se-offices.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/se-offices") || request()->is("admin/se-offices/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                <span class="iconText">{{ trans('cruds.seOffice.title') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('ee_office_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.ee-offices.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/ee-offices") || request()->is("admin/ee-offices/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                <span class="iconText">{{ trans('cruds.eeOffice.title') }}</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        @can('office_job_access')
            <li class="c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="far fa-user-circle c-sidebar-nav-icon"></i>
                    <span class="iconText">&#160;Jobs</span>
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('office_job_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.office-jobs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/office-jobs") || request()->is("admin/office-jobs/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-shield-alt c-sidebar-nav-icon">

                                </i>
                                <span class="iconText">{{ trans('cruds.officeJob.title') }}</span>
                            </a>
                        </li>
                    @endcan    
                    @can('office_job_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.office-job-defaults.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/office-job-defaults") || request()->is("admin/office-job-defaults/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-shield-alt c-sidebar-nav-icon">

                                </i>
                                <span class="iconText">{{ trans('cruds.officeJobDefault.title') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('audit_log_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.audit-logs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">
                                </i>
                                <span class="iconText">{{ trans('cruds.auditLog.title') }}</span>
                            </a>
                        </li>
                    @endcan 
                </ul>
            </li>
        @endcan

       

        <li class="c-sidebar-nav-item">
            <a href="{{route('employee.hr_grievance')}}" class="c-sidebar-nav-link" target="_self">
                <i class="fa fa-comments c-sidebar-nav-icon"></i>
                <span class="iconText">&#160;Track Hr Grievance</span>
            </a>
        </li> 
        <li class="c-sidebar-nav-item">
            <a href="{{route('acr.myacrs')}}" class="c-sidebar-nav-link" target="_self">
                <i class="fa fa-copy c-sidebar-nav-icon"> </i>
                <span class="iconText">&#160;Track ACR</span>
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="fas fa-power-off c-sidebar-nav-icon"></i>
                <span class="iconText">&#160;{{ trans('global.logout') }}</span>
            </a>
        </li>
        @if(Auth::check())
            @if(Auth::user()->chat_id <= 10000)
            <li class="c-sidebar-nav-item">
              <a href="{{ route('telegram.connect') }}" class="c-sidebar-nav-link">
                @include('icon.icon',['icon'=>'telegram','width'=>24,'height'=>24])
                <span class="iconText">Telegtam Integeration</span>
              </a>
            </li>
            @endif
        @endif
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
