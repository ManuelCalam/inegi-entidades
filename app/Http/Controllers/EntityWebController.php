<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntityRequest;
use App\Http\Requests\UpdateEntityRequest;
use App\Models\Entity;
use App\Models\VegetationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntityWebController extends Controller
{
    public function index(Request $request)
    {
        $entities = Entity::with('vegetationTypes')->orderBy('name')->get();
        $regionalCenters = config('regions');
        $vegetationTypes = VegetationType::orderBy('name')->get();
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
        $data = $request->validated();
        $vegetationTypeIds = $data['vegetation_types'];
        unset($data['vegetation_types']);

        DB::transaction(function () use ($data, $vegetationTypeIds) {
            $entity = Entity::create($data);
            $entity->vegetationTypes()->sync($vegetationTypeIds);
        });

        return redirect()
            ->route('entities.web')
            ->with('success', 'Entidad federativa agregada exitosamente.');
    }

    public function show(Entity $entity)
    {
        $entities = Entity::orderBy('name')->get();
        $regionalCenters = config('regions');
        $vegetationTypes = VegetationType::orderBy('name')->get();
        
        return view('entities.web', compact(
            'entities',
            'regionalCenters',
            'vegetationTypes',
            'entity'
        ));
    }


    public function update(UpdateEntityRequest $request, Entity $entity)
    {
        $data = $request->validated();

        DB::transaction(function () use ($request, $entity, $data) {
            if ($request->has('vegetation_types')) {
                $entity->vegetationTypes()->sync($data['vegetation_types']);
                unset($data['vegetation_types']);
            }

            $entity->update($data);
        });

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
