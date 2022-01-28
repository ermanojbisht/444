<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCeOfficeRequest;
use App\Http\Requests\StoreCeOfficeRequest;
use App\Http\Requests\UpdateCeOfficeRequest;
use App\Models\CeOffice;
use App\Models\Employee;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CeOfficeController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('ce_office_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CeOffice::query()->select(sprintf('%s.*', (new CeOffice)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'ce_office_show';
                $editGate = 'ce_office_edit';
                $deleteGate = 'ce_office_delete';
                $crudRoutePart = 'ce-offices';

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
            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : "";
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
            $table->editColumn('contact_no', function ($row) {
                return $row->contact_no ? $row->contact_no : "";
            });
            $table->editColumn('email_2', function ($row) {
                return $row->email_2 ? $row->email_2 : "";
            });
            $table->editColumn('lat', function ($row) {
                return $row->lat ? $row->lat : "";
            });
            $table->editColumn('lon', function ($row) {
                return $row->lon ? $row->lon : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.ceOffices.index');
    }

    public function create()
    {
        abort_if(Gate::denies('ce_office_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ceOffices.create');
    }

    public function store(StoreCeOfficeRequest $request)
    {
        $ceOffice = CeOffice::create($request->all());

        return redirect()->route('admin.ce-offices.index');
    }

    public function edit(CeOffice $ceOffice)
    {
        abort_if(Gate::denies('ce_office_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ceOffices.edit', compact('ceOffice'));
    }

    public function update(UpdateCeOfficeRequest $request, CeOffice $ceOffice)
    {
        $ceOffice->update($request->all());

        return redirect()->route('admin.ce-offices.index');
    }

    public function show(CeOffice $ceOffice)
    {
        abort_if(Gate::denies('ce_office_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ceOffice->load('ceOfficeSeOffices');

        return view('admin.ceOffices.show', compact('ceOffice'));
    }

    public function destroy(CeOffice $ceOffice)
    {
        abort_if(Gate::denies('ce_office_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ceOffice->delete();

        return back();
    }

    public function massDestroy(MassDestroyCeOfficeRequest $request)
    {
        CeOffice::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

