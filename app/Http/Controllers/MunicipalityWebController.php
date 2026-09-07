<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreMunicipalityRequest;
use App\Http\Requests\UpdateMunicipalityRequest;

use App\Models\Entity;
use App\Models\Municipality;

class MunicipalityWebController extends Controller
{
    public function index(Request $request)
    {
        $entities = Entity::orderBy('name')->get();

        $municipalities = Municipality::with('entity')
            ->orderBy('id')
            ->get();

        $municipality = null;


        if ($request->filled('search')) {

            $municipality = Municipality::find($request->search);

            if (!$municipality) {
                return view('municipalities.index', compact(
                    'municipalities',
                    'entities',
                    'municipality'
                ))->with([
                    'search' => 'No se encontró un municipio con ese ID.'
                ]);
            }
        }

        return view('municipalities.index', compact(
            'municipalities',
            'entities',
            'municipality'
        ));
    }

    public function store(StoreMunicipalityRequest $request)
    {
        Municipality::create($request->validated());

        return redirect()
            ->route('municipalities.web')
            ->with('success', 'Municipio agregado correctamente.');
    }


    public function show(Municipality $municipality)
    {
        $municipalities = Municipality::with('entity')
            ->orderBy('id')
            ->get();

        $entities = Entity::orderBy('name')->get();

        return view('municipalities.index', compact(
            'municipalities',
            'entities',
            'municipality'
        ));
    }


    public function update(UpdateMunicipalityRequest $request, Municipality $municipality) {
        $municipality->update($request->validated());

        return redirect()
            ->route('municipalities.web')
            ->with('success', 'Municipio actualizado correctamente.');
    }


    public function destroy(Municipality $municipality)
    {
        $municipality->delete();

        return redirect()
            ->route('municipalities.web')
            ->with('success', 'Municipio eliminado correctamente.');
    }
}