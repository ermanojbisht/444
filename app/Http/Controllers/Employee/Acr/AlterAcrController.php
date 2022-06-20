<?php

namespace App\Http\Controllers\Employee\Acr;

use App\Http\Controllers\Controller;
use App\Jobs\Acr\MakeAcrPdfOnSubmit;
use App\Models\Acr\Acr;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AlterAcrController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Acr\Acr  $acr
     * @return \Illuminate\Http\Response
     */
    public function show(Acr $acr) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Acr\Acr  $acr
     * @return \Illuminate\Http\Response
     */
    public function edit(Acr $acr) {

        abort_if(Gate::denies('acr-special'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($acr->old_accept_no || !$acr->accept_no) {
            return 'not allowed as alreadey updated';
        }
        return view('employee.acr.alteracr', compact('acr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Acr\Acr  $acr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Acr $acr) {
        abort_if(Gate::denies('acr-special'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->validate($request,
            [
                'accept_no' => 'required',
                'final_accept_remark' => 'required|min:20',
                'old_accept_no' => 'required',
            ]
        );
        $acr->update(
            $request->all()
        );
        //final no ki entry karo
         $acr->updateFinalNo();
        //    make pdf  and mail notification
        dispatch(new MakeAcrPdfOnSubmit($acr, 'correctnotice'));

        return redirect()->route('employee.acr.view',['employee'=>$acr->employee_id])->with('success', 'ACR Final Marks Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Acr\Acr  $acr
     * @return \Illuminate\Http\Response
     */
    public function destroy(Acr $acr) {
        //
    }
}
