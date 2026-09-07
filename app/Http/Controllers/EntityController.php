<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntityRequest;
use App\Http\Requests\UpdateEntityRequest;
use App\Models\Entity;

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
}
