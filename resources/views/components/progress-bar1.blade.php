<div class="progress-group mt-2">
    <div class="progress-group-header">
        <svg class="icon icon-lg me-2">
            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
        </svg>
        <div>{{$title}}</div>
        <div class="ms-auto fw-semibold">{{$percentage}}%</div>
    </div>
    <div class="progress-group-bars">
        <div class="progress progress-thin">
            <div class="progress-bar bg-{{$type}}" role="progressbar" style="width: {{$percentage}}%" aria-valuenow="{{$percentage}}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
</div>
