<?php

namespace App\Http\Controllers\FormCreator;

use App\Http\Controllers\Controller;
use App\Http\Resources\StateDigest;
use App\models\FormCreator\State;
use Illuminate\Http\Request;

class StateController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(State::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'status' => 0,
            'states' => StateDigest::collection(State::orderBy('name')->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, State $state)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state)
    {
        //
    }
}
