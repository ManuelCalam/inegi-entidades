<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntityRequest;
use App\Http\Requests\UpdateEntityRequest;
use App\Models\Entity;
use Illuminate\Http\Request;

class EntityWebController extends Controller
{
    public function index(Request $request)
    {
        $entities = Entity::orderBy('name')->get();
        $regionalCenters = config('regions');
        $vegetationTypes = config('vegetation');
        $entity = null;

        if ($request->filled('search')) {
            $entity = Entity::where('name', $request->search)->first();


            if(!$entity){
                return view('entities.web', compact(
                    'entities',
                    'regionalCenters',
                    'vegetationTypes',
                    'entity'
                ))->with('searchError', 'No se encontró una entidad con ese nombre.');
            }
        }

        return view('entities.web', compact(
            'entities',
            'regionalCenters',
            'vegetationTypes',
            'entity'
        ));
    }

    public function store(StoreEntityRequest $request){
        Entity::create($request->validated());

        return redirect()
            ->route('entities.web')
            ->with('success', 'Entidad federativa agregada exitosamente.');
    }

    public function show(Entity $entity)
    {
        $entities = Entity::orderBy('name')->get();
        $regionalCenters = config('regions');
        $vegetationTypes = config('vegetation');

        return view('entities.web', compact(
            'entities',
            'regionalCenters',
            'vegetationTypes',
            'entity'
        ));
    }

    public function update(UpdateEntityRequest $request, Entity $entity){
        $entity->update($request->validated());


        return redirect()
            ->route('entities.web')
            ->with('success', 'Entidad federativa actualizada exitosamente.');
    }

    public function destroy(Entity $entity){
        $entity->delete();

        return redirect()
            ->route('entities.web')
            ->with('success', 'Entidad federativa eliminada correctamente');
    }
}
