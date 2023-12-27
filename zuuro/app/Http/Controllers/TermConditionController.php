<?php

namespace App\Http\Controllers;

use App\Models\TermCondition;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTermConditionRequest;
use App\Http\Requests\UpdateTermConditionRequest;

class TermConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTermConditionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTermConditionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TermCondition  $termCondition
     * @return \Illuminate\Http\Response
     */
    public function show(TermCondition $termCondition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TermCondition  $termCondition
     * @return \Illuminate\Http\Response
     */
    public function edit(TermCondition $termCondition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTermConditionRequest  $request
     * @param  \App\Models\TermCondition  $termCondition
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTermConditionRequest $request, TermCondition $termCondition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TermCondition  $termCondition
     * @return \Illuminate\Http\Response
     */
    public function destroy(TermCondition $termCondition)
    {
        //
    }
}
