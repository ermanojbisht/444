<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySeOfficeRequest;
use App\Http\Requests\StoreSeOfficeRequest;
use App\Http\Requests\UpdateSeOfficeRequest;
use App\Models\CeOffice;
use App\Models\Employee;
use App\Models\SeOffice;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SeOfficeController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;


    public function index(Request $request)
    {
        abort_if(Gate::denies('se_office_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SeOffice::with(['ce_office'])->select(sprintf('%s.*', (new SeOffice)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'se_office_show';
                $editGate = 'se_office_edit';
                $deleteGate = 'se_office_delete';
                $crudRoutePart = 'se-offices';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('name_h', function ($row) {
                return $row->name_h ? $row->name_h : "";
            });
            $table->editColumn('head_emp_code', function ($row) {
                $emp = Employee::find($row->head_emp_code);
                if ($emp) {
                    return $emp->name . " code : " . $emp->id;
                } else {
                    return "no data";
                }
            });
            $table->editColumn('email_1', function ($row) {
                return $row->email_1 ? $row->email_1 : "";
            });
            $table->editColumn('email_2', function ($row) {
                return $row->email_2 ? $row->email_2 : "";
            });
            $table->editColumn('contact_no', function ($row) {
                return $row->contact_no ? $row->contact_no : "";
            });
            $table->editColumn('lat', function ($row) {
                return $row->lat ? $row->lat : "";
            });
            $table->editColumn('lon', function ($row) {
                return $row->lon ? $row->lon : "";
            });
            $table->addColumn('ce_office_name', function ($row) {
                return $row->ce_office ? $row->ce_office->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'ce_office']);

            return $table->make(true);
        }

        $ce_offices = CeOffice::get();

        return view('admin.seOffices.index', compact('ce_offices'));
    }

    public function create()
    {
        abort_if(Gate::denies('se_office_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ce_offices = CeOffice::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.seOffices.create', compact('ce_offices'));
    }

    public function store(StoreSeOfficeRequest $request)
    {
        $seOffice = SeOffice::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $seOffice->id]);
        }

        return redirect()->route('admin.se-offices.index');
    }

    public function edit(SeOffice $seOffice)
    {
        abort_if(Gate::denies('se_office_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ce_offices = CeOffice::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $seOffice->load('ce_office');

        return view('admin.seOffices.edit', compact('ce_offices', 'seOffice'));
    }

    public function update(UpdateSeOfficeRequest $request, SeOffice $seOffice)
    {
        $seOffice->update($request->all());

        return redirect()->route('admin.se-offices.index');
    }

    public function show(SeOffice $seOffice)
    {
        abort_if(Gate::denies('se_office_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seOffice->load('ce_office', 'seOfficeEeOffices');

        return view('admin.seOffices.show', compact('seOffice'));
    }

    public function destroy(SeOffice $seOffice)
    {
        abort_if(Gate::denies('se_office_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seOffice->delete();

        return back();
    }

    public function massDestroy(MassDestroySeOfficeRequest $request)
    {
        SeOffice::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('se_office_create') && Gate::denies('se_office_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new SeOffice();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
