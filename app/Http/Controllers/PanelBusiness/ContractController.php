<?php

namespace App\Http\Controllers\PanelBusiness;

use App\Http\Controllers\Controller;
use App\models\Business\Contract;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('panelBusiness.pages.allBusiness', ['contracts' => Contract::all()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Business\Contract  $contract
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Contract $contract) {
        return view('panelBusiness.pages.contract', ['contract' => $contract]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Business\Contract  $contract
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Contract $contract) {

        $request->validate([
            "description" => "required"
        ]);

        $contract->description = $request["description"];
        $contract->save();

        return response()->json([
            'status' => 'ok'
        ]);

    }

    public function getContract(Request $request) {

        $request->validate([
            'type' => ['required', Rule::in(['tour', 'agency', 'hotel', 'restaurant'])]
        ], $messages = [
            'type.required' => 'لطفا نوع خدمت قابل ارائه را مشخص کنید.',
            'type.in' => 'خدمت قابل ارائه نامعتبر است.',
        ]);

        return response()->json([
            "status" => "ok",
            "contract" => Contract::where('type', $request["type"])->first()->description
        ]);

    }

}
