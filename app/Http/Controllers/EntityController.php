<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntityRequest;
use App\Http\Requests\UpdateEntityRequest;
use App\Models\Entity;
use App\Models\VegetationType;
use Illuminate\Http\Request;

class EntityController extends Controller
{

    public function index()
    {
        return response()->json(Entity::all(), 200);
    }


    public function store(StoreEntityRequest $request)
    {
        $entity = Entity::create($request->validated());

        return response()->json([
            'message' => "Entidad agregada exitosamente.",
            'data' => $entity
        ], 201);
    }

    public function show(Entity $entity)
    {
        return response()->json($entity, 200);
    }


    public function update(UpdateEntityRequest $request, Entity $entity)
    {
        $entity->update($request->validated());

        return response()->json([
            'message' => 'Entidad actualizada exitosamente.',
            'data' => $entity
        ], 200);
    }


    public function destroy(Entity $entity)
    {
        $entity->delete();

        return response()->json([
            'message' => "Entidad eliminada exitosamente.",
        ], 200);
    }


    public function availableNeighbors(Entity $entity)
    {
        $neighborIds = $entity->neighbors()->pluck('entities.id');

        $neighbors = Entity::query()
            ->where('id', '!=', $entity->id)
            ->whereNotIn('id', $neighborIds)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($neighbors, 200);
    }


    public function addNeighbors(Request $request, Entity $entity)
    {
        $validated = $request->validate([
            'entity_ids' => ['required', 'array', 'min:1'],
            'entity_ids.*' => ['integer', 'exists:entities,id'],
        ]);

        $entityIds = collect($validated['entity_ids'])
            ->unique()
            ->reject(fn ($id) => $id == $entity->id)
            ->values()
            ->all();

        $entity->neighbors()->syncWithoutDetaching($entityIds);

        $neighbors = $entity->neighbors()
            ->orderBy('name')
            ->get(['entities.id', 'entities.name']);

        return response()->json([
            'message' => 'Entidades colindantes agregadas exitosamente.',
            'data' => $neighbors,
        ], 200);
    }


    public function availableVegetation(Entity $entity)
    {
        $vegetationIds = $entity->vegetationTypes()->pluck('vegetation_types.id');

        $vegetationTypes = VegetationType::query()
            ->whereNotIn('id', $vegetationIds)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($vegetationTypes, 200);
    }

    public function addVegetation(Request $request, Entity $entity)
    {
        $validated = $request->validate([
            'vegetation_ids' => ['required', 'array', 'min:1'],
            'vegetation_ids.*' => ['integer', 'exists:vegetation_types,id'],
        ]);

        $vegetationIds = collect($validated['vegetation_ids'])
            ->unique()
            ->values()
            ->all();

        $entity->vegetationTypes()->syncWithoutDetaching($vegetationIds);

        $vegetationTypes = $entity->vegetationTypes()
            ->orderBy('name')
            ->get(['vegetation_types.id', 'vegetation_types.name']);

        return response()->json([
            'message' => 'Tipos de vegetación agregados exitosamente.',
            'data' => $vegetationTypes,
        ], 200);
    }

    public function allVegetation()
    {
        return response()->json(
            VegetationType::orderBy('name')->get(['id', 'name']),
            200
        );
    }

    public function removeNeighbor(Entity $entity, Entity $neighbor)
    {
        $entity->neighbors()->detach($neighbor->id);

        $updatedNeighbors = $entity->neighbors()
            ->orderBy('name')
            ->get(['entities.id', 'entities.name']);

        return response()->json([
            'message' => 'Entidad colindante removida exitosamente.',
            'data' => $updatedNeighbors,
        ], 200);
    }

    public function removeVegetation(Entity $entity, VegetationType $vegetation)
    {
        $entity->vegetationTypes()->detach($vegetation->id);

        $updatedVegetation = $entity->vegetationTypes()
            ->orderBy('name')
            ->get(['vegetation_types.id', 'vegetation_types.name']);

        return response()->json([
            'message' => 'Tipo de vegetación removido exitosamente.',
            'data' => $updatedVegetation,
        ], 200);
    }

}
