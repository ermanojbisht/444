<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEeOfficeRequest;
use App\Http\Requests\StoreEeOfficeRequest;
use App\Http\Requests\UpdateEeOfficeRequest;
use App\Models\EeOffice;
use App\Models\Employee;
use App\Models\SeOffice;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EeOfficeController extends Controller
{
    use MediaUploadingTrait , CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('ee_office_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EeOffice::with(['se_office'])->select(sprintf('%s.*', (new EeOffice)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'ee_office_show';
                $editGate      = 'ee_office_edit';
                $deleteGate    = 'ee_office_delete';
                $crudRoutePart = 'ee-offices';
                $phyProgressGate = 'none';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row',
                     'phyProgressGate'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
             $table->editColumn('head_emp_code', function ($row) {
                $emp=Employee::find($row->head_emp_code);
                if($emp){
                    return $emp->name." code : ".$emp->id;
                }else{
                    return "no data";
                }               
            });
        /*    $table->editColumn('name_h', function ($row) {
                return $row->name_h ? $row->name_h : "";
            });*/
      /*      $table->editColumn('district', function ($row) {
                return $row->district ? $row->district : "";
            });*/
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : "";
            });
          /*  $table->editColumn('email_2', function ($row) {
                return $row->email_2 ? $row->email_2 : "";
            });*/
          /*  $table->editColumn('contact_no', function ($row) {
                return $row->contact_no ? $row->contact_no : "";
            });*/
        /*    $table->editColumn('lat', function ($row) {
                return $row->lat ? $row->lat : "";
            });
            $table->editColumn('lon', function ($row) {
                return $row->lon ? $row->lon : "";
            });
*/
            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        $se_offices = SeOffice::get();

        return view('admin.eeOffices.index', compact('se_offices'));
    }

    public function create()
    {
        abort_if(Gate::denies('ee_office_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $se_offices = SeOffice::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.eeOffices.create', compact('se_offices'));
    }

    public function store(StoreEeOfficeRequest $request)
    {
        $eeOffice = EeOffice::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $eeOffice->id]);
        }

        return redirect()->route('admin.ee-offices.index');
    }

    public function edit(EeOffice $eeOffice)
    {
        abort_if(Gate::denies('ee_office_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $se_offices = SeOffice::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $eeOffice->load('se_office')->load('officeHead');

        return view('admin.eeOffices.edit', compact('se_offices', 'eeOffice'));
    }

    public function update(UpdateEeOfficeRequest $request, EeOffice $eeOffice)
    {
        //Log::info("request = ".print_r($request->all(),true));
        $eeOffice->update($request->all());

        return redirect()->route('admin.ee-offices.index');
    }

    public function show(EeOffice $eeOffice)
    {
        abort_if(Gate::denies('ee_office_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eeOffice->load('se_office')->load('officeHead');

        return view('admin.eeOffices.show', compact('eeOffice'));
    }

    public function destroy(EeOffice $eeOffice)
    {
        abort_if(Gate::denies('ee_office_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eeOffice->delete();

        return back();
    }

    public function massDestroy(MassDestroyEeOfficeRequest $request)
    {
        EeOffice::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('ee_office_create') && Gate::denies('ee_office_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new EeOffice();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
    /**
     * [allUsersToRelatedOfficeUpdateInDB]
     * @return [mass update to all eeOffice] 
     */
    public function allUsersToRelatedOfficeUpdateInDB()
    {
        EeOffice::all()->map(function($ee){
            $ee->allUsersToRelatedOfficeUpdateInDB();
        });
    }

    public function getAes(EeOffice $eeoffice)
    {
        $aeString = '<option value="">Select Ae</option>';
        $aes =   $eeoffice->aes;
        foreach($aes as $ae){
            $aeString.='<option value="'.$ae['ae_id'].'">'.$ae['name'].'</option>';
        }
        return $aeString;
    }
    
}
