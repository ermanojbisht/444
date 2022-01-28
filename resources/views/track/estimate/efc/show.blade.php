@extends('layouts.type200.main')
@section('styles')
	@include('layouts._commonpartials.css._leaflet')
      @include('layouts._commonpartials.css.lightbox')
      <style type="text/css">
            html {
                scroll-padding-top: 100px;
                }

            body {
                position: relative;
                overflow-y: auto;
                }

            .bg-success {
              --cui-bg-opacity: 1;
              background-color: rgba(var(--cui-success-rgb), var(--cui-bg-opacity)) !important;
              color: black;
            }
            .bg-warning {
              --cui-bg-opacity: 1;
              background-color: rgba(var(--cui-warning-rgb), var(--cui-bg-opacity)) !important;
              color: black;
            }

            
      </style>
@endsection
@section('pagetitle')
      
      <a type="button" class="btn btn-outline-info p-1" href="{{route('efc.index')}}" data-coreui-toggle="tooltip" data-coreui-html="true" data-coreui-placement="bottom" title="<h5>EFC List</h5>">
            <svg class="icon icon-xl">
              <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-arrow-circle-left')}}"></use>
            </svg>
      </a>
      @include('layouts._commonpartials.language_switcher')
      <div class="btn-group" role="group" aria-label="Basic example2">
            <a type="button" class="btn btn-outline-info p-1" href="{{$_SERVER['REQUEST_URI'];}}#General" data-coreui-toggle="tooltip" data-coreui-html="true" data-coreui-placement="bottom" title="<h5>Go to Top of Page</h5>">
                  <svg class="icon icon-xl">
                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-chevron-circle-up-alt')}}"></use>
                  </svg>
            </a>
            <a type="button" class="btn btn-outline-info p-1" href="{{$_SERVER['REQUEST_URI'];}}#Comparison" data-coreui-toggle="tooltip" data-coreui-html="true" data-coreui-placement="bottom" title="<h5>Go to Comparison Section</h5>">
                  <svg class="icon icon-xl">
                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-calculator')}}"></use>
                  </svg></a>
            <a type="button" class="btn btn-outline-info p-1" href="{{$_SERVER['REQUEST_URI'];}}#Images" data-coreui-toggle="tooltip" data-coreui-html="true" data-coreui-placement="bottom" title="<h5>Go to Images Section</h5>">
                  <svg class="icon icon-xl">
                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-image')}}"></use>
                  </svg>
            </a>
            <a type="button" class="btn btn-outline-info p-1" href="{{$_SERVER['REQUEST_URI'];}}#Map" data-coreui-toggle="tooltip" data-coreui-html="true" data-coreui-placement="bottom" title="<h5>Go to Map Section</h5>">
                  <svg class="icon icon-xl">
                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-map')}}"></use>
                  </svg>
            </a>
      </div>
      <a type="button" class="btn btn-outline-info p-1 mx-3" href="{{route('track.estimate.view',$instanceEstimate->id)}}" data-coreui-toggle="tooltip" data-coreui-html="true" data-coreui-placement="bottom" title="<h5>Estimate View</h5>">
            <svg class="icon icon-xl">
              <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-search')}}"></use>
            </svg>
      </a>
@endsection
@section('content')
      <div class="bg-success p-2" style="--cui-bg-opacity: .5;" id="General">
           <p class="h3 fw-bolder text-dark p-3 ">{{$instanceEstimate->instance->instance_name}}
           @if($instanceEstimate->WORK_code)
                <a  class="btn btn-sm btn-info" target="_blank"
                    href="{{config('site.app_url_mis').'/'.config('site.missite_workdetail_address').'/'.$instanceEstimate->WORK_code}}">
                    {{$instanceEstimate->WORK_code}}
                </a>
            @endif
            @if($instanceEstimate->new_Work_Code)
                <a  class="btn btn-sm btn-success " target="_blank"
                    href="{{config('site.app_url_mis').'/'.config('site.missite_workdetail_address').'/'.$instanceEstimate->new_Work_Code}}">
                    {{$instanceEstimate->new_Work_Code}}
                </a>

            @endif
                  <a  class="btn btn-sm btn-info " target="_blank"
                    href="http://mis.pwduk.in/im/segmentMap/4004">
                    Existing Road
                  </a>
                  <a  class="btn btn-sm btn-info " target="_blank"
                    href="http://mis.pwduk.in/im/bridgReport/99">
                    Existing Bridge
                  </a>
            </p>
      </div>
      <div class="card bg-success p-2" style="--cui-bg-opacity: .2;">
            {{-- <p class="card-title h4 fw-bold text-white bg-info px-3 py-1" id="General">{{ __('efc.general')}}</p> --}}
            <div class="card-body">
                  <div class="row h5" >
                        <div class="col-md-6 col-lg-3 card p-2">
                              <p class="m-0 ">
                                    <span class="headingDot">{{ __('efc.constituency')}}</span>
                                    <span class="float-end">
                                          @foreach ($constiuencies as $constituency)                                      
                                          @if(app()->getLocale() == 'en')
                                                {{$constituency->name}}
                                          @else
                                                {{$constituency->name_h}}
                                          @endif
                                          @endforeach
                                    </span>
                              </p>
                              <hr class="p-0 my-1">
                              <p class="m-0">
                                    <span class="headingDot">{{ __('efc.loksabha')}}</span>
                                    <span class="float-end">
                                          @if(app()->getLocale() == 'en')
                                                {{$instanceEstimate->loksabha->name}}
                                          @else
                                                {{$instanceEstimate->loksabha->name_h}}
                                          @endif
                                    </span>
                              </p>
                              <hr class="p-0 my-1">
                              <p class="m-0">
                                    <span class="headingDot">{{ __('efc.office')}}</span>
                                    <span class="float-end">
                                          @if(app()->getLocale() == 'en')
                                                {{$instanceEstimate->officeName->name}}
                                          @else
                                                {{$instanceEstimate->officeName->name_h}}
                                          @endif
                                    </span>
                              </p>
                        </div>
                        <div class="col-md-6 col-lg-3 card p-2">
                              <p class="m-0 ">
                                    <span class="headingDot">{{ __('efc.estCost')}}</span>
                                    <span class="float-end rsLasc">{{$instanceEstimate->estimate_cost}}</span>
                              </p>
                              <hr class="p-0 my-1">
                              <p class="m-0">
                                    <span class="headingDot">{{ __('efc.tscCost')}}</span>
                                    <span class="float-end rsLasc">{{$instanceEstimate->tsc_cost}}</span>
                              </p>
                              <hr class="p-0 my-1">
                              <p class="m-0">
                                    <span class="headingDot">{{ __('efc.taCost')}}</span>
                                    <span class="float-end rsLasc">{{$instanceEstimate->ta_cost}}</span>
                              </p>
                        </div>
                        <div class="col-lg-6 card p-2">
                              <p class="m-0">
                                    <span class="headingDot">{{ __('efc.land_availabilty')}}</span>
                                    <span class="float-end">{{$instanceEstimate->land_availabilty}}</span>
                              </p>
                              <hr class="p-0 my-1">
                              <p class="m-0">
                                    <span class="headingDot">{{ __('efc.land_type')}}</span>
                                    <span class="float-end">{{$instanceEstimate->land_type}}</span>
                              </p>
                              <hr class="p-0 my-1">
                              <p class="m-0">
                                    <span class="headingDot">{{ __('efc.land_area')}}</span>
                                    <span class="float-end">{{$instanceEstimate->land_area}}</span>
                              </p>
                        </div>
                        @if($sub_works->count() > 1)
                        <div class="card p-2">
                              <div class="row">
                                    <div class="col-auto">
                                          <p class="fs-5 fw-semibold">{{ __('efc.sub_work')}} : </p>
                                    </div>
                                    <div class="col-auto">
                                          @foreach($sub_works as $key => $sub_work)
                                                @if($loop->iteration == 1)
                                                @else
                                                      <p>{{$loop->iteration -1}} - {{$sub_work}}</p>
                                                @endif
                                          @endforeach
                                    </div>
                              </div>
                        </div>
                        @endif
                        <div class="card p-2">
                              <div class="row p-2">
                                    <span class="col-auto fw-semibold headingDot ">{{ __('efc.tentative_time')}}</span>
                                    <span class="col-auto detailText">{{$instanceEstimate->completion_months}}</span>
                              </div>
                              <div class="row p-2">
                                    <span class="col-md-3 fw-semibold headingDot ">{{ __('efc.due_to')}}</span>
                                    <span class="col-md-9 detailText">{{ (app()->getLocale() == 'en')?config('mis_entry.estimate.due_to')[$instanceEstimate->due_to]:config('mis_entry.estimate.due_to_h')[$instanceEstimate->due_to] }}</span>
                              </div>
                              <div class="row p-2">
                                    <span class="col-md-3 fw-semibold headingDot ">{{ __('efc.reference_no')}}</span>
                                    <span class="col-md-9 detailText">{{$instanceEstimate->reference_no}}</span>
                              </div>
                              <div class="row p-2">
                                    <span class="col-md-3 fw-semibold headingDot ">{{ __('efc.objective')}}</span>
                                    <span class="col-md-9 detailText">{{$instanceEstimate->objective}}</span>
                              </div>
                              <div class="row p-2">
                                    <span class="col-md-3 fw-semibold headingDot ">{{ __('efc.provisions')}}</span>
                                    <span class="col-md-9 detailText">{!!$instanceEstimate->provisions!!}</span>
                              </div>
                              <div class="row p-2">
                                    <span class="col-md-3 fw-semibold headingDot ">{{ __('efc.connectivity_status')}}</span>
                                    <span class="col-md-9 detailText">{{$instanceEstimate->connectivity_status}}</span>
                              </div>
                              <div class="row p-2">
                                    <span class="col-md-3 fw-semibold headingDot ">{{ __('efc.benefited_villages')}}</span>
                                    <span class="col-md-6 detailText">
                                    @if($villages->count()>0)
                                          <table class="table table-sm col-md-9">
                                            <thead>
                                              <tr>
                                                <th scope="col" rowspan=2 class="align-middle">#</th>
                                                <th scope="col" rowspan=2 class="align-middle">Village Code</th>
                                                <th scope="col" rowspan=2 class="align-middle">Name</th>
                                                <th scope="col" colspan=3 class="text-center">Population</th>

                                              </tr>
                                              <tr>
                                                <th scope="col" class="text-center">SC</th>
                                                <th scope="col" class="text-center">ST</th>
                                                <th scope="col" class="text-center">Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($villages as $village)
                                                    <tr>
                                                      <th scope="row">{{$loop->index+1}}</th>
                                                      <td>{{$village->id}}</td>
                                                      <td>{{$village->name}}</td>
                                                      <td class="text-end">{{$village->P_SC}}</td>
                                                      <td class="text-end">{{$village->P_ST}}</td>
                                                      <td class="text-end">{{$village->Tot_p}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                      <td colspan=3>Total </td>
                                                      <td colspan=1 class="text-end">{{ $villages->sum('P_SC') }}  </td>
                                                      <td colspan=1 class="text-end">{{ $villages->sum('P_ST') }}  </td>
                                                      <td colspan=1 class="text-end">{{ $villages->sum('Tot_p') }}  </td>
                                            </tr>
                                            </tfoot>
                                          </table>
                                    @endif

                                          {{-- @if($villages->count()>0)
                                                <table class="table table-sm" >
                                                      <thead>
                                                          <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Village Code</th>
                                                            <th scope="col">Name</th>
                                                            <th scope="col">Population</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                            @foreach ($villages as $village)
                                                                <tr>
                                                                  <th scope="row">{{$loop->index+1}}</th>
                                                                  <td>{{$village->id}}</td>
                                                                  <td>{{$village->name}}</td>
                                                                  <td>{{$village->Tot_p}}</td>
                                                                </tr>
                                                            @endforeach
                                                      </tbody>
                                                      <tfoot>
                                                            <tr>
                                                                  <th colspan=3 class="text-center">Total </th>
                                                                  <th colspan=1>{{ $villages->sum('Tot_p') }}  </th>
                                                            </tr>
                                                      </tfoot>
                                                </table>
                                          @else
                                                <p></p>
                                          @endif --}}
                                    @if($ulbs->count()>0)
                                          <span class="text-danger">नगरीय क्षेत्र</span>
                                          <table class="table table-sm" >
                                                <thead>
                                                    <tr>
                                                      <th scope="col">#</th>
                                                      <th scope="col">Type</th>
                                                      <th scope="col">Name</th>
                                                      <th scope="col">Ward</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                      @foreach ($ulbs as $ulb)
                                                          <tr>
                                                            <th scope="row">{{$loop->index+1}}</th>
                                                            <td>{{$ulb->type_name}}</td>
                                                            <td>{{$ulb->title}}</td>
                                                            <td>{{$ulb->pivot->wards}}</td>
                                                          </tr>
                                                      @endforeach
                                                </tbody>
                                          </table>
                                    @endif
                                    </span>
                              </div>
                        </div>
                  </div>
            </div>
            <div class="card-body p-1 bg-white">
            <p class="card-title h4 fw-bold text-white bg-success px-3 py-1" id="Comparison">{{ __('efc.comparison')}}</p>
                  <table class="table table-sm table-bordered border-info">
                        <thead class="table-warning border-info">
                            <tr class="text-center align-middle">
                              <th rowspan="2">#</th>
                              <th rowspan="2">Items</th>
                              <th rowspan="2">Qty</th>
                              <th rowspan="2">Unit</th>
                              <th colspan="2">As Per Standard</th>
                              <th rowspan="2">Amount <br> in DPR</th>
                              <th rowspan="2">(+) Excess/<br> (-) Saving</th>
                              <th rowspan="2">Remark</th>
                            </tr>
                            <tr class="text-center align-middle">
                              <th>Rate</th>
                              <th>Amount</th>

                            </tr>
                        </thead>
                        @php
                              $dpr_gtotal = $std_gtotal = 0;
                        @endphp
                        @foreach($allsubestimateFeatureGroupsFeatures as $subEstimatekey => $featuregroups)
                              @if($subEstimatekey !== 0)
                                    <tr>
                                          <th colspan="9" class="fw-semibold fs-6 bg-warning" style="--cui-bg-opacity: .6;">{{$sub_works[$subEstimatekey]}}</th>
                                    </tr>
                              @endif
                              <tbody>
                                    @php
                                          $dpr_total = $std_total = $std_rate = 0;
                                    @endphp
                                    @foreach($featuregroups as $featureGroupKey=>$features)
                                          <tr class="text-start fw-semibold bg-success" style="--cui-bg-opacity: .1;">
                                                <td></td>
                                                <td colspan="8">
                                                      {{$featureGroupNames[$featureGroupKey]}}
                                                </td>
                                          </tr>
                                          @foreach($features as $feature)
                                                      @php
                                                            $dpr_total = $dpr_total + $feature->cost;
                                                            $std_rate = $std_rate + $feature->rate;
                                                            $std_total = $std_total + ($feature->rate * $feature->qty);
                                                      @endphp
                                                      <tr class="text-end">
                                                            <td class="text-center">{{$loop->iteration}}</td>
                                                            <td class="text-start">{{$feature->type->name}}</td>
                                                            <td>{{number_format($feature->qty,3)}}</td>
                                                            <td >{{$feature->type->unit}}</td>
                                                            <td >{{number_format($feature->rate,2)}}</td>
                                                            <td class="twodigit">{{number_format($feature->rate * $feature->qty,2)}}</td>
                                                            <td class="twodigit">{{number_format($feature->cost,2)}}</td>
                                                            <td>
                                                                  @if( ($feature->rate * $feature->qty) > $feature->cost)
                                                                        <span>
                                                                  @else
                                                                        <span class="text-danger">
                                                                  @endif
                                                                        {{number_format($feature->cost - ($feature->rate * $feature->qty),2)}}
                                                                  </span>

                                                            </td>
                                                            <td class="text-left">{{$feature->remark}}</td>
                                                      </tr>
                                          @endforeach
                                                      <tr class="text-end">
                                                            <th></th>
                                                            <th>Sub Total</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th>{{number_format($std_rate,2)}}</th>
                                                            <th>{{number_format($std_total,2)}}</th>
                                                            <th>{{number_format($dpr_total,2)}}</th>
                                                            <th>
                                                                  <span class="flot-end">{{number_format($dpr_total - $std_total,2)}}</span>
                                                            </th>
                                                            <th>
                                                                  @if($dpr_total - $std_total >0)
                                                                       <span class="float-start text-danger"> Excess</span>
                                                                  @else
                                                                       <span class="float-start text-danger"> Saving</span>

                                                                  @endif

                                                            </th>
                                                        </tr>
                                                      @php
                                                            $dpr_gtotal = $dpr_gtotal + $dpr_total;
                                                            $std_gtotal = $std_gtotal + $std_total;
                                                      @endphp
                                    @endforeach
                              </tbody>
                        @endforeach
                        <tfoot class="table-warning border-info">
                              <tr class="text-end">
                                    <th></th>
                                    <th>Grand Total</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>{{number_format($std_gtotal,2)}}</th>
                                    <th>{{number_format($dpr_gtotal,2)}}</th>
                                    <th>
                                          <span class="flot-end">{{number_format($dpr_gtotal - $std_gtotal,2)}}</span>
                                    </th>
                                    <th>
                                          @if($dpr_gtotal - $std_gtotal >0)
                                               <span class="float-start text-danger"> Excess</span>
                                          @else
                                               <span class="float-start text-danger"> Saving</span>

                                          @endif

                                    </th>
                              </tr>
                        </tfoot>
                  </table>
            </div>
            <div class="card-body p-1 bg-white">
            <p class="card-title h4 fw-bold text-white bg-success px-3 py-1" id="Images">{{ __('efc.images')}}</p>
                        @include("track.estimate.partial._Images",['images' => $images])
            </div>
            <div class="card-body p-1 bg-white">
            <p class="card-title h4 fw-bold text-white bg-success px-3 py-1" id="Map">{{ __('efc.map')}}</p>
                  <div style="width: 100%; height: 60vh;" id="map"></div>
            </div>
      </div>
@endsection
@section('footscripts')
@include('layouts._commonpartials.js._leaflet')
<script type="text/javascript">

      // for digit afeter number
      var allTds = document.getElementsByClassName("rsLasc twodigit");
      for (var i = 0; i < allTds.length; i++) {
        allTds[i].innerHTML = parseFloat(allTds[i].innerHTML).toFixed(2);
      }

      


      // Make basemap
      const map = new L.Map('map', { center: new L.LatLng(58.4, 43.0), zoom: 11 });
      
      @include('layouts._commonpartials.scripts.mapbaselayer')
      map.addControl(L.control.basemaps({
          basemaps: basemaps,
          tileX: 0,  // tile X coordinate
          tileY: 0,  // tile Y coordinate
          tileZ: 1   // tile zoom level
      }));

      map.addControl(new L.Control.Fullscreen());
      
      @foreach($kmlFiles as $kml)
          var track = new L.KML( '{{$kml}}', {async: true})
          .on('loaded', function (e) {
              map.fitBounds(e.target.getBounds());
          })
          .addTo(map);
      @endforeach
      // Basemap     
</script>

@endsection
