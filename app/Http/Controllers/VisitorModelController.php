<?php

namespace App\Http\Controllers;

use App\Models\VisitorModel;
use App\Http\Requests\StoreVisitorModelRequest;
use App\Http\Requests\UpdateVisitorModelRequest;

class VisitorModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $VisitorModel = VisitorModel::all();
        return view('VisitorModelPage',['VisitorModel'=> $VisitorModel ]);
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
     * @param  \App\Http\Requests\StoreVisitorModelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVisitorModelRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VisitorModel  $visitorModel
     * @return \Illuminate\Http\Response
     */
    public function show(VisitorModel $visitorModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VisitorModel  $visitorModel
     * @return \Illuminate\Http\Response
     */
    public function edit(VisitorModel $visitorModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVisitorModelRequest  $request
     * @param  \App\Models\VisitorModel  $visitorModel
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVisitorModelRequest $request, VisitorModel $visitorModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VisitorModel  $visitorModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(VisitorModel $visitorModel)
    {
        //
    }
}
