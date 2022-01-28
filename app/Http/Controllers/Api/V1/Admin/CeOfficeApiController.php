<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCeOfficeRequest;
use App\Http\Requests\UpdateCeOfficeRequest;
use App\Http\Resources\Admin\CeOfficeResource;
use App\Models\CeOffice;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CeOfficeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ce_office_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CeOfficeResource(CeOffice::all());
    }

    public function store(StoreCeOfficeRequest $request)
    {
        $ceOffice = CeOffice::create($request->all());

        return (new CeOfficeResource($ceOffice))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CeOffice $ceOffice)
    {
        abort_if(Gate::denies('ce_office_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CeOfficeResource($ceOffice);
    }

    public function update(UpdateCeOfficeRequest $request, CeOffice $ceOffice)
    {
        $ceOffice->update($request->all());

        return (new CeOfficeResource($ceOffice))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CeOffice $ceOffice)
    {
        abort_if(Gate::denies('ce_office_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ceOffice->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
