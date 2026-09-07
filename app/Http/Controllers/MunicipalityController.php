<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMunicipalityRequest;
use App\Http\Requests\UpdateMunicipalityRequest;
use App\Models\Municipality;


class MunicipalityController extends Controller
{

    public function index()
    {
        $fields = Municipality::with('entity')->get();

        return response()->json([
            'data'=> $fields],200);
    }


    public function store(StoreMunicipalityRequest $request)
    {
        $fields = Municipality::create($request->validated());
        
        return response()->json([
            'message' => 'Municipio creado correctamente.',
            'data' => $fields
        ], 201);
    }


    public function show(Municipality $municipality)
    {
        $municipality->load('entity');

        return response()->json([
            'message' => 'Municipio encontrado.',
            'data' => $municipality
        ], 200);
    }


    public function update(UpdateMunicipalityRequest $request, Municipality $municipality)
    {
        $municipality->update($request->validated());
        $municipality->load('entity');

        return response()->json([
            'message' => 'Municipio actualizado correctamente.',
            'data' => $municipality
        ], 200);
    }

    public function destroy(Municipality $municipality)
    {
        $municipality->delete();

        return response()->json([
            'message' => 'Municipio eliminado correctamente.'
        ], 200);
    }
}
