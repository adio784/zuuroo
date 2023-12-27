<?php

namespace App\Http\Controllers;

use App\Models\SmsDebtor;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSmsDebtorRequest;
use App\Http\Requests\UpdateSmsDebtorRequest;

class SmsDebtorController extends Controller
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
     * @param  \App\Http\Requests\StoreSmsDebtorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSmsDebtorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SmsDebtor  $smsDebtor
     * @return \Illuminate\Http\Response
     */
    public function show(SmsDebtor $smsDebtor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SmsDebtor  $smsDebtor
     * @return \Illuminate\Http\Response
     */
    public function edit(SmsDebtor $smsDebtor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSmsDebtorRequest  $request
     * @param  \App\Models\SmsDebtor  $smsDebtor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSmsDebtorRequest $request, SmsDebtor $smsDebtor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SmsDebtor  $smsDebtor
     * @return \Illuminate\Http\Response
     */
    public function destroy(SmsDebtor $smsDebtor)
    {
        //
    }
}
