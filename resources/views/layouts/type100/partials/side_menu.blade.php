<style type="text/css">

        .btn-toggle {
          display: inline-flex;
          width: 100%;
          align-items: center;
          padding: .25rem .5rem;
          font-size: large;
          color: rgba(0, 0, 0, .65);
          background-color: #00ccdc; /* transparent;*/
          border: 0;
        }
        .btn-toggle:hover,
        .btn-toggle:focus {
          color: rgba(0, 0, 0, .85);
          background-color: #d2f4ea;
        }

        .btn-toggle::after {
          width: 1.25em;
          line-height: 0;
          position: absolute;
            right: 0;
          content: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='rgba%280,0,0,.5%29' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 14l6-6-6-6'/%3e%3c/svg%3e");
          transition: transform .35s ease;
          transform-origin: .5em 50%;
        }

        .btn-toggle[aria-expanded="true"] {
          color: rgba(0, 0, 0, .85);
        }
        .btn-toggle[aria-expanded="true"]::after {
          transform: rotate(90deg);
        }

        .btn-toggle-nav a {
          width: 100%;
          background-color: #cacfd0;
          color: black;
          display: inline-flex;
          padding: .1875rem .5rem;
          margin-top: .125rem;
          margin-left: 1.25rem;
          text-decoration: none;
          font-size: large;

        }
        .btn-toggle-nav a:hover,
        .btn-toggle-nav a:focus {
          background-color: #d2f4ea;
        }

        .iconSvg{
            height: 24px;
            width: 24px;
            fill: black; 
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin:  round; 
        }
</style>
<ul class="nav nav-pills flex-column mb-auto">
  <li class="text-light h3">Track Instances</li>
  <li class="mb-1">
    <button class="btn btn-toggle " data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
      <span class="iconSvg">{!!config('mis_entry.svgIcon')['estimate']!!}</span>
      Estimate
    </button>
    <div class="collapse" id="dashboard-collapse">
      <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
        <li class="sidebar-item {{($active=='allEstimateList')?'active':''}}">
            <a class="sidebar-link " href="{{route('index')}}">
                <i class="align-middle" data-feather="sliders"></i> 
                <span class="align-middle">View All Estimate</span>
            </a>
        </li>
        <li class="sidebar-item {{($active=='create_Instance')?'active':''}} ">
            <a class="link-dark rounded" href="{{route('instance.create')}}">
                <span class="iconSvg">{!!config('mis_entry.svgIcon')['plus']!!}</span>
                <span class="align-middle"> Create New </span>
            </a>
        </li>
        <li class="sidebar-item {{($active=='estimateReport')?'active':''}} ">
            <a class="link-dark rounded" href="{{route('estimate.report')}}">
                <i class="align-middle" data-feather="list"></i> 
                <span class="align-middle">Estimate List </span>
            </a>
        </li>
        <li class="sidebar-item {{($active=='myInstances')?'active':''}} ">
            <a class="sidebar-link" href="{{route('myInstances')}}">
                <i class="align-middle" data-feather="user-plus"></i> <span class="align-middle"> Created Instances </span>
            </a>
        </li>
        <li class="sidebar-item {{($active=='receivedInstances')?'active':''}} ">
            <a class="sidebar-link" href="{{route('receivedInstances')}}">
                {!!config('mis_entry.svgIcon')['inbox']!!}
                <span class="align-middle"> Inbox </span>
            </a>
        </li>
        <li class="sidebar-item {{($active=='sentInstances')?'active':''}} ">
            <a class="sidebar-link" href="{{route('sentEstimateInstances')}}">
                {!!config('mis_entry.svgIcon')['sent']!!}
                <span class="align-middle"> Sent </span>
            </a>
        </li>
        @isset ($instance_estimate_id)
            @if($instance_estimate_id)
            <li class="sidebar-item" id="estitems">
                Details of Estimate ID {{$instance_estimate_id}}
                <ul id="estitems" class="sidebar-dropdown list-unstyled collapse show" data-bs-parent="#sidebar" style="">
                    <li class="sidebar-item {{($active=='viewEstimateInstance')?'active':''}} ">
                        <a class="sidebar-link" href="{{route('track.estimate.view',$instance_estimate_id)}}">
                            <i class="align-middle" data-feather="book"></i> <span
                                class="align-middle">Estimate Track History </span>
                        </a>
                    </li>
                    <li class="sidebar-item {{($active=='estimate_doc_list')?'active':''}} ">
                        <a class="sidebar-link" href="{{route('instance.estimate.doclist-1',$instance_estimate_id)}}">
                            <i class="align-middle" data-feather="book"></i> <span
                                class="align-middle">Estimate Docs </span>
                        </a>
                    </li>
                    <li class="sidebar-item {{($active=='estimate_feature_list')?'active':''}} ">
                        <a class="sidebar-link"
                           href="{{route('instanceEstimate.instanceEstimateFeature.index',$instance_estimate_id)}}">
                            <i class="align-middle" data-feather="book"></i> <span class="align-middle">Estimate Features </span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
        @endisset
      </ul>
    </div>
  </li>
  <li class="mb-1">
    <button class="btn btn-toggle align-items-center rounded " data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
        <span class="iconSvg">{!!config('mis_entry.svgIcon')['law']!!}</span>
        Court Case
    </button>
    <div class="collapse" id="orders-collapse">
      <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
        <li><a href="#" class="link-dark rounded">New</a></li>
        <li><a href="#" class="link-dark rounded">Processed</a></li>
        <li><a href="#" class="link-dark rounded">Shipped</a></li>
        <li><a href="#" class="link-dark rounded">Returned</a></li>
      </ul>
    </div>
  </li>
  <li class="mb-1">
    <button class="btn btn-toggle align-items-center rounded " data-bs-toggle="collapse" data-bs-target="#acr-collapse" aria-expanded="false">
        <span class="iconSvg">{!!config('mis_entry.svgIcon')['acr']!!}</span>
        ACR
    </button>
    <div class="collapse" id="acr-collapse">
      <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
        <li><a href="#" class="link-dark rounded">New</a></li>
        <li><a href="#" class="link-dark rounded">Processed</a></li>
        <li><a href="#" class="link-dark rounded">Shipped</a></li>
        <li><a href="#" class="link-dark rounded">Returned</a></li>
      </ul>
    </div>
  </li>
  <li class="border-top my-3"></li>

{{--     <div class="btn-toolbar p-0" role="toolbar" aria-label="Toolbar with button groups">
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
    </div> --}}
</ul>
