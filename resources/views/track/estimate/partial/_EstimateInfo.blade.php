<div class="card">
        <div class="card-body">
            <div class="d-grid gap-0 fs-6">
              <div class="p-0 fs-4 fw-semibold">{{ $instance->instance_name }}</div>
                    @if($addDetails)
                        <div class="p-0 fw-semibold">
                                <span class="fw-semibold text-primary">Office :</span>
                                <span class="fst-italic">{{ $instanceEstimate->officeName->name }}</span>
                        </div>
                        <div class="p-0 fw-semibold">
                                <span class="fw-semibold text-primary">District :</span>
                                <span class="fst-italic">{{ $instanceEstimate->District->name }}</span>
                            &emsp; 
                                <span class="fw-semibold text-primary">Block :</span>
                                <span class="fst-italic">
                                    @foreach($blocks as $block) 
                                        {{$block}} &nbsp; 
                                    @endforeach 
                                </span>
                            &emsp; 
                                <span class="fw-semibold text-primary">Constituency :</span>
                                <span class="fst-italic">
                                    @foreach($Constituencies as $Constituencie) 
                                        {{$Constituencie}} &nbsp; 
                                    @endforeach 
                                </span>
                            &emsp;
                                <span class="fw-semibold text-primary">Loksabha :</span>
                                <span class="fst-italic">{{ $instanceEstimate->loksabha->name }}</span>
                        </div>
                        <div class="p-0 fw-semibold">
                                <span class="fw-semibold text-primary">Estimate Cost :</span>
                                <span class="fst-italic rsLasc text-primary">{{number_format($instanceEstimate->estimate_cost,2)}}</span>
                                @if($instanceEstimate->tsc_cost)
                                    &emsp;
                                    <span class="fw-semibold text-primary">Cost By TSC :</span>
                                    <span class="fst-italic rsLasc text-primary">{{ number_format($instanceEstimate->tsc_cost,2) }}</span>
                                @endif
                                @if($instanceEstimate->ta_cost)
                                    &emsp;
                                    <span class="fw-semibold text-primary">Cost By Advisior :</span>
                                    <span class="fst-italic rsLasc text-primary">{{ number_format($instanceEstimate->ta_cost,2) }}</span>
                                @endif
                        </div>
                        <div class="p-0 fw-semibold">
                                @if($instanceEstimate->road_length)
                                    <span class="fw-semibold text-primary">Road Length :</span>
                                    <span class="fst-italic">{{ number_format($instanceEstimate->road_length,3) }} KM</span>
                                @endif
                                @if($instanceEstimate->bridge_no)
                                    &emsp;
                                    <span class="fw-semibold text-primary">Bridge :</span>
                                    <span class="fst-italic">{{ number_format($instanceEstimate->road_length,3) }} No.</span>
                                    <span class="fst-italic">( Span {{ number_format($instanceEstimate->bridge_span,2) }} Rmt.)</span>

                                @endif
                                @if($instanceEstimate->building_no)
                                    &emsp;
                                    <span class="fw-semibold text-primary">Building :</span>
                                    <span class="fst-italic">{{ number_format($instanceEstimate->building_no,3) }} No.</span>
                                @endif
                        </div>
                        <div class="p-0 fw-semibold">
                                <span class="fw-semibold text-primary">Work Type :</span>
                                <span class="fst-italic">{{($instanceEstimate->worktype)? $instanceEstimate->worktype->name : '--' }}</span>
                        </div>
                        <div class="p-0 fw-semibold">
                                <span class="fw-semibold text-primary">Reasons for Estimate Preparation:</span>
                                <span class="fst-italic">{{ config('mis_entry.estimate.due_to')[$instanceEstimate->due_to]??'none' }}</span>
                        </div>
                        <div class="p-0 fw-semibold">
                                <span class="fw-semibold text-primary">References:</span>
                                <span class="fst-italic">{{$instanceEstimate->reference_no}}</span>
                        </div>
                        @if($instanceEstimate->objective)
                        <div class="p-0 fw-semibold">
                                <span class="fw-semibold text-primary">Provisions in Estimate :</span>
                                <span class="fst-italic">{{$instanceEstimate->objective}}</span>
                        </div>
                        @endif
                        @if($instanceEstimate->WORK_code)
                        <div class="p-0 fw-semibold">
                                <span class="fw-semibold text-primary">Previous Sanction WORK's Code :</span>
                                <span class="fst-italic">{{$instanceEstimate->WORK_code}}</span>
                        </div>
                        @endif
                        @if($instanceEstimate->other_Remark)
                        <div class="p-0 fw-semibold">
                                <span class="fw-semibold text-primary">Remarks :</span>
                                <span class="fst-italic">{{$instanceEstimate->other_Remark}}</span>
                        </div>
                        @endif
                        @if($instanceEstimate->completion_months)
                        <div class="p-0 fw-semibold">
                                <span class="fw-semibold text-primary">Tentative Time for Work Execution :</span>
                                <span class="fst-italic">{{$instanceEstimate->completion_months}} Months</span>
                        </div>
                        @endif
                        @if($instanceEstimate->new_WORK_Code)
                        <div class="p-0 fw-semibold">
                                <span class="fw-semibold text-primary">New Work's Code :</span>
                                <span class="fst-italic">{{$instanceEstimate->new_WORK_Code}}</span>
                        </div>
                        @endif
                        @if($instanceEstimate->provisions)
                        <div class="p-0 fw-semibold">
                                <span class="fw-semibold text-primary">Provisions in Estimate :</span>
                                <span class="fst-italic">{!!$instanceEstimate->provisions!!}</span>
                        </div>
                        @endif
                        @if($instanceEstimate->land_availabilty)
                        <div class="p-0 fw-semibold">
                                <span class="fw-semibold text-primary">Land Availabilty :</span>
                                <span class="fst-italic">{{$instanceEstimate->land_availabilty}}</span>
                        </div>
                        @endif
                        @if($instanceEstimate->land_type)
                        <div class="p-0 fw-semibold">
                                <span class="fw-semibold text-primary">Land Type :</span>
                                <span class="fst-italic">{{$instanceEstimate->land_type}}</span>
                        </div>
                        @endif
                        @if($instanceEstimate->land_area)
                        <div class="p-0 fw-semibold">
                                <span class="fw-semibold text-primary">Land Type :</span>
                                <span class="fst-italic">{{$instanceEstimate->land_area}}</span>
                        </div>
                        @endif
                        @if($instanceEstimate->urban)
                        <div class="p-0 fw-semibold">
                                <span class="fw-semibold text-primary">Urban Area :</span>
                                <span class="fst-italic">{{ ($instanceEstimate->urban == 1) ? 'Yes' : 'No' }}</span>
                        </div>
                        @endif
                        @if($instanceEstimate->connectivity_status)
                        <div class="p-0 fw-semibold">
                                <span class="fw-semibold text-primary">Connectivity Satus :</span>
                                <span class="fst-italic">{{$instanceEstimate->connectivity_status}}</span>
                        </div>
                        @endif
                        @if($instanceEstimate->villages)
                        <div class="p-0 fw-semibold">
                                <span class="fw-semibold text-primary">Villages  :</span>
                                <span class="fst-italic">{{$instanceEstimate->villages}}</span>
                        </div>
                        @endif
                        @if($instanceEstimate->efc_date)
                        <div class="p-0 fw-semibold">
                                <span class="fw-semibold text-primary">EFC Date :</span>
                                <span class="fst-italic">{{$instanceEstimate->efc_date}}</span>
                        </div>
                        @endif
                        @if($instanceEstimate->WORK_code)
                        <div class="p-0 fw-semibold">
                            <span class="fw-semibold text-primary">Parent Work :</span>
                            <a  class="btn btn-sm btn-outline-info" target="_blank"
                                href="{{config('site.app_url_mis').'/'.config('site.missite_workdetail_address').'/'.$instanceEstimate->WORK_code}}">
                                {{$instanceEstimate->WORK_code}}
                            </a>
                        </div>
                        @endif
                        @if($instanceEstimate->new_Work_Code)
                        <div class="p-0 fw-semibold">
                            <span class="fw-semibold text-primary">New Work :</span>
                            <a  class="btn btn-sm btn-outline-info" target="_blank"
                                href="{{config('site.app_url_mis').'/'.config('site.missite_workdetail_address').'/'.$instanceEstimate->new_Work_Code}}">
                                {{$instanceEstimate->new_Work_Code}}
                            </a>
                        </div>
                        @endif
                @endif
                <hr class="p-0 m-0"/>
                <div class="p-0 fw-semibold">
                        <span class="fw-semibold text-primary">Current Status :</span>
                        <span class="fst-italic">{{$instance->currentStatus->name}}</span>
                </div>
            </div>
            <p class="fs-6 fw-semibold fst-italic">Created By : {{ $instance->creator->name }} -{{ $instance->creator->designation}} on {{ $instance->created_at->format('d M Y') }} </p>
        </div>
    </div>
 
