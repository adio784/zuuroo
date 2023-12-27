<?php

namespace App\Http\Controllers;

use App\Models\loan_history;
use App\Http\Requests\Storeloan_historyRequest;
use App\Http\Requests\Updateloan_historyRequest;

class LoanHistoryController extends Controller
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
     * @param  \App\Http\Requests\Storeloan_historyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storeloan_historyRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\loan_history  $loan_history
     * @return \Illuminate\Http\Response
     */
    public function show(loan_history $loan_history)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\loan_history  $loan_history
     * @return \Illuminate\Http\Response
     */
    public function edit(loan_history $loan_history)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updateloan_historyRequest  $request
     * @param  \App\Models\loan_history  $loan_history
     * @return \Illuminate\Http\Response
     */
    public function update(Updateloan_historyRequest $request, loan_history $loan_history)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\loan_history  $loan_history
     * @return \Illuminate\Http\Response
     */
    public function destroy(loan_history $loan_history)
    {
        //
    }
}
