<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreEeOfficeRequest;
use App\Http\Requests\UpdateEeOfficeRequest;
use App\Http\Resources\Admin\EeOfficeResource;
use App\Models\EeOffice;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EeOfficeApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('ee_office_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EeOfficeResource(EeOffice::with(['se_office'])->get());
    }

    public function store(StoreEeOfficeRequest $request)
    {
        $eeOffice = EeOffice::create($request->all());

        return (new EeOfficeResource($eeOffice))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EeOffice $eeOffice)
    {
        abort_if(Gate::denies('ee_office_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EeOfficeResource($eeOffice->load(['se_office']));
    }

    public function update(UpdateEeOfficeRequest $request, EeOffice $eeOffice)
    {
        $eeOffice->update($request->all());

        return (new EeOfficeResource($eeOffice))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EeOffice $eeOffice)
    {
        abort_if(Gate::denies('ee_office_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eeOffice->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

