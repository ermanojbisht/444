<?php

namespace App\Http\Controllers\Track;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Constituency;
use App\Models\District;
use App\Models\Employee;
use App\Models\Loksabha;
use App\Models\Track\Instance;
use App\Models\WorkType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class InstanceReportController extends Controller {

    public function index(Request $request) {
        $districts = District::all();
        $Loksabhas = Loksabha::all();
        $blocks = Block::all();
        $constituencies = Constituency::all();
        $workType = WorkType::all();

        return view('track.reports.list', compact('workType', 'Loksabhas', 'districts', 'blocks', 'constituencies'))
            ->with('status', 'Instance added Successfully !!!'); // 'instances', 
    }

    public function ajaxDataForEstimateReport(Request $request)
    {
        if ($request->ajax()) {

            $instances = Instance::whereHas('estimate', function ($query) use ($request) {

                if($request->district_id){
                    $query=$query->where('instance_estimates.district_id', $request->district_id);
                }

                if($request->block_id){
                    $query=$query->where('instance_estimates.block_id', $request->block_id);
                }

                if($request->constituency_id){
                    $query=$query->where('instance_estimates.constituency_id', $request->constituency_id);
                }

                
                if($request->loksabha_id){
                    $query=$query->where('instance_estimates.loksabha_id', $request->loksabha_id);
                }

                if($request->worktype_id){
                    $query=$query->where('instance_estimates.worktype_id', $request->worktype_id);
                }


                if($request->dueTo_id){
                    $query=$query->where('instance_estimates.due_to', $request->dueTo_id);
                }

            })->with(['estimate.district','estimate.block', 'estimate.constituency', 'estimate.loksabha', 'estimate.worktype',
            'estimate.officeName', 'instanceLastRecognizeUser', 'currentStatus']);


            $instances = $instances->orderBy('instances.id', 'DESC')->get();

            $table = Datatables::of($instances);

            $table->editColumn('estimate.created_at', function ($row) {
                return $row->estimate->created_at ? $row->estimate->created_at->format('d-m-y') : '';
            });

            $table->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('d-m-y') : '';
            });

            $table->editColumn('estimate.due_to', function ($row) {
                $dueto = $row->estimate->due_to; 
               foreach(config('mis_entry.estimate.due_to') as $key => $value)
                 {
                   if($key == $dueto)
                       return $value;
                 }
           });


            return $table->make(true);
        }
    }


}
