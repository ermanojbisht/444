<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreSeOfficeRequest;
use App\Http\Requests\UpdateSeOfficeRequest;
use App\Http\Resources\Admin\SeOfficeResource;
use App\Models\SeOffice;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SeOfficeApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('se_office_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SeOfficeResource(SeOffice::with(['ce_office'])->get());
    }

    public function store(StoreSeOfficeRequest $request)
    {
        $seOffice = SeOffice::create($request->all());

        return (new SeOfficeResource($seOffice))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SeOffice $seOffice)
    {
        abort_if(Gate::denies('se_office_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SeOfficeResource($seOffice->load(['ce_office']));
    }

    public function update(UpdateSeOfficeRequest $request, SeOffice $seOffice)
    {
        $seOffice->update($request->all());

        return (new SeOfficeResource($seOffice))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SeOffice $seOffice)
    {
        abort_if(Gate::denies('se_office_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seOffice->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
