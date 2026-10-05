<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LopHoc;
use Illuminate\Http\Request;
use App\Http\Resources\LopHocResource;

class LopHocController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return LopHocResource::collection(LopHoc::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LopHoc $lopHoc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LopHoc $lopHoc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LopHoc $lopHoc)
    {
        //
    }
}
