<div class="card p-1 bg-transparent">
    <div class="m-0 px-2">
        <p class="h3 fw-bolder" style="color:#700844;">
            <span class="float-start">
                Bond no. : {{$bond->bond_no}} dated {{date_format($bond->bond_date,"d M Y")}}
            </span>
            <span class="float-end ">
                ({{config('contract.stage.'.$bond->stage)}})
            </span>
            <span class="float-end text-uppercase">
                {{config('contract.status.'.$bond->status)}}
            </span>
        </p>
    </div>
    <div class="fw-bolder text-info m-0 px-2">
        <p class="fw-bolder h4 fst-italic m-0" style="color:#700844;">{{$bond->title}}</p>
        <p class="m-0">
            Contractor: {{$bond->contractor->name}} {{$bond->gstn}}
        </p>
        <p class="m-0">
            Bond Cost : Rs {{$bond->cost}}
            @if($bond->var_cost != 0)
                (Variation of Rs {{$bond->var_cost}} Sanctioned )
                Updated Bond Cost Rs. {{$bond->cost + $bond->var_cost}}
            @endif
        </p>
        @foreach($bond->works as $key => $work)
            <p class="m-0">
                ({{$key+1}})-
                    <a class="btn btn-sm btn-info" target="_blank" href="{{config('site.app_url_mis').'/'.config('site.missite_workdetail_address').'/'.$work->WORK_code.$anchorifAny}}">
                          {{$work->WORK_code}}
                    </a>
                {{$work->WORK_name}}
                <a href="{{route('bond',['workcode'=>$work->WORK_code])}}" class="btn btn-xs btn-info pull-right">Back to Contract Register of Work</a>
            </p>
        @endforeach
    </div>
    <div class="card-group m-0 px-2">
        <div class="card p-0 m-0 bg-transparent border border-primary">
            <p class="p-0 m-0 fw-bolder text-center bg-primary text-white">Agreement's Date</p>
            <p class="p-0 m-0 fw-bolder text-primary row">
                <span class="col-md-6">
                    Start :
                </span>
                <span class="col-md-6">
                    {{date_format($bond->start_date,"d M Y")}}
                </span>
                <span class="col-md-6">
                    Completion :
                </span>
                <span class="col-md-6">
                    {{date_format($bond->initial_completion_date,"d M Y")}}
                </span>
            </p>
        </div>
        <div class="card p-0 m-0 bg-transparent border border-primary">
            <p class="p-0 m-0 fw-bolder text-center bg-primary text-white">Completion Date</p>
            <p class="p-0 m-0 fw-bolder text-primary row">
                <span class="col-md-6">
                    Intended :
                </span>
                <span class="col-md-6">
                    {{date_format($bond->intended_completion_date,"d M Y")}}
                </span>
                <span class="col-md-6">
                    Actual :
                </span>
                <span class="col-md-6">
                    @if($bond->adc)
                        {{date_format($bond->adc,"d M Y")}}
                    @else
                        --
                    @endif
                </span>
            </p>
        </div>
        <div class="card p-0 m-0 bg-transparent border border-primary">
            <p class="p-0 m-0 fw-bolder text-center bg-primary text-white">DLP</p>
            <p class="p-0 m-0 fw-bolder text-primary row">
                @if($bond->adc)
                    <span class="col-md-6">
                    From :
                </span>
                    <span class="col-md-6">
                    {{date_format($bond->dlp_start,"d M Y")}}
                </span>
                    <span class="col-md-6">
                    Till :
                </span>
                    <span class="col-md-6">
                    {{date_format($bond->dlp_end,"d M Y")}}
                </span>
                @else
                    <span class="text-center">{{$bond->dlp_period}} Days</span>
                @endif
            </p>
        </div>
        <div class="card p-0 m-0 bg-transparent border border-primary">
            <p class="p-0 m-0 fw-bolder text-center bg-primary text-white">Maintenance</p>
            <p class="p-0 m-0 fw-bolder text-primary row">
                @if($bond->adc)
                    <span class="col-md-6">
                    From :
                </span>
                    <span class="col-md-6">
                    {{date_format($bond->mnt_start,"d M Y")}}
                </span>
                    <span class="col-md-6">
                    Till :
                </span>
                    <span class="col-md-6">
                    {{date_format($bond->mnt_end,"d M Y")}}
                </span>
                @else
                    <span class="text-center">{{$bond->mnt_period}} Days</span>
                @endif
            </p>
        </div>
    </div>
</div>

