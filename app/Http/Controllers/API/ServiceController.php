<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Services;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Services::all();
        return response()->json($services, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $services = Services::create($request->all());
        return response()->json($services, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = Services::findOrFail($id);
        return response()->json($service, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $service = Services::findOrFail($id);
        $service->update($request->all());
        return response()->json($service, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Services::findOrFail($id);
        $service->delete();
        return response()->json(null, 204);
    }
}
