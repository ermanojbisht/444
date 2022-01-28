<?php

namespace App\Http\Controllers\Track;

use App\Http\Controllers\Controller;
use App\Models\Track\EstimateFeatureGroup;
use App\Models\Track\Instance;
use App\Models\Track\InstanceEstimate;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Log;
use Yajra\DataTables\DataTables;

class EfcReportController extends Controller
{
    /**
     * @var mixed
     */
    protected $user;

    /**
     * @return mixed
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = Auth::User();
            return $next($request);
        });

    }

    public function index(Request $request)
    {
         if ($request->ajax()) {

            $instances = Instance::whereHas('estimate', function ($query) use ($request) {               
                //for query
                $query=$query->whereNotNull('instance_estimates.efc_date');
                //  $query=$query->orderBy('instance_estimates.efc_date',DESC);
            })->with(['estimate.district','estimate.block', 'estimate.constituency', 'estimate.loksabha', 'estimate.officeName']);

            //$instances = $instances->orderBy('instances.id', 'DESC')->get();

            $instances = $instances->get()->sortByDesc(function ($temp, $key) {
                            return $temp['estimate']['efc_date']->getTimestamp();
                         });

            $table = Datatables::of($instances) ;

            $table->editColumn('instance_name', function ($row) {
               return '<a class="text-decoration-none" target="_blank" href="'.route('efc.show',[$row->estimate->id]).'">'.$row->instance_name.'</a>';
            });

            $table->editColumn('estimate.new_Work_Code', function ($row) {
                if($row->estimate->new_Work_Code)
                return '<a class="btn btn-sm btn-success" target="_blank" href="'.config('site.app_url_mis').'/'.config('site.missite_workdetail_address').'/'.$row->estimate->new_Work_Code.'">'
                    .$row->estimate->new_Work_Code.
                '</a>';
            });

/* */

            $table->editColumn('estimate.created_at', function ($row) {
                return $row->estimate->created_at ? $row->estimate->created_at->format('d M y') : '';
            });

            $table->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('d M y') : '';
            });

            $table->editColumn('estimate.efc_date', function ($row) {
                return [
                   'display' => $row->estimate->efc_date->format('d M y'),
                   'timestamp' => $row->estimate->efc_date->timestamp,
                ] ;
            });

           /* $table->filterColumn('estimate.efc_date', function ($query, $keyword) {

               $query->whereRaw("DATE_FORMAT(created_at,'%d %M %y') LIKE ?", ["%$keyword%"]);

            });*/

            $table->editColumn('estimate.due_to', function ($row) {
                $dueto = $row->estimate->due_to; 
               foreach(config('mis_entry.estimate.due_to') as $key => $value)
                 {
                   if($key == $dueto)
                       return $value;
                 }
           });

            $table->rawColumns(['instance_name','estimate.new_Work_Code']);

            return $table->make(true);
        }

        return view('track.estimate.efc.index');
    }

    public function show(InstanceEstimate $instanceEstimate)
    {
        
        $images = $instanceEstimate->pics()->get();      
        $villages = $instanceEstimate->villages()->get();      
        $ulbs = $instanceEstimate->ulbs()->get();      
        $kmlFiles = $instanceEstimate->kml()->get()->pluck('address'); 
        $allsubestimateFeatureGroupsFeatures = $instanceEstimate->features()->with('type','type.group')->get()->groupBy(['estimate_group_id','type.group.id']);  
        //Log::info("features = ".print_r($features,true)); 
        $allsubestimateFeatureGroupsFeatures = $allsubestimateFeatureGroupsFeatures->sortKeys();   
        //Log::info("features sorted.1111111111111111111 = ".print_r($features,true)); 

        $sub_works =  $instanceEstimate->modifiedEstimateGroupCollection(); 
        $featureGroupNames=EstimateFeatureGroup::all()->pluck('name','id');
         if($instanceEstimate->constituency_id==0){
                $constiuencies=$instanceEstimate->constituencies;
          }else{
                $constiuencies=[$instanceEstimate->constituency];
          }
              
        return view('track.estimate.efc.show',compact('instanceEstimate','kmlFiles','images','allsubestimateFeatureGroupsFeatures','villages','ulbs','sub_works','featureGroupNames','constiuencies'));
    }
}
