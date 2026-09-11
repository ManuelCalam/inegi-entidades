<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFireRequest;
use App\Http\Requests\UpdateFireRequest;
use App\Models\Entity;
use App\Models\Fire;
use App\Models\Municipality;
use App\Models\VegetationType;
use Carbon\Carbon;
use Illuminate\Http\Request;

use function Laravel\Prompts\select;

class FireController extends Controller
{

    public function index(Request $request)
    {
        $entities = Entity::select('id', 'name', 'key')
            ->orderBy('name')
            ->get();

        $fire = null;

        if ($request->filled('search')) {
            $fire = Fire::where('fire_key', $request->search)->first();

            if (!$fire) {
                return redirect()->route('fires.index')
                    ->with('searchError', 'No se encontró ningún incendio con la clave proporcionada.');
            }
        }

        return view('fires.index', compact('entities', 'fire'));
    }

    public function store(StoreFireRequest $request)
    {
        $data = $request->validated();
        $data['fire_key'] = $this->calculateFireKey($data['entity_id']);

        Fire::create($data);

        return redirect()
            ->route('fires.index')
            ->with('success', 'Incendio registrado correctamente');
    }

    public function update(UpdateFireRequest $request, Fire $fire){
        $fire->update($request->validated());

        return redirect()
            ->route('fires.index')
            ->with('success', 'Incendio actualizado correctamente.');
    }

    public function destroy(Fire $fire){
        $fire->delete();

        return redirect()
            ->route('fires.index')
            ->with('success', 'Incendio eliminado correctamente');
    }

    public function getMunicipalities(int $entity_id) {
                $municipalities = Municipality::where('entity_id', $entity_id)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
        return response()->json($municipalities, 200);
    }

    public function getVegetationTypes(int $entity_id){
        $entity = Entity::findOrFail($entity_id);

        $vegetationTypes = $entity->vegetationTypes()
            ->select('vegetation_types.id', 'vegetation_types.name')
            ->orderBy('vegetation_types.name')
            ->get();

        return response()->json($vegetationTypes, 200);
    }

    public function generateFireKey(int $entity_id)
    {
        $fireKey = $this->calculateFireKey($entity_id);

        return response()->json([
            'fire_key' => $fireKey
        ], 200);
    }

    private function calculateFireKey(int $entityId): string
    {
        $entity = Entity::findOrFail($entityId);
        $entityKey = $entity->key;

        $currentYear = Carbon::now()->format('y'); // Obtener los últimos dígitos del año actual

        // Obtener el de fechas correspondientes al año actual (2026-01-01 00:00:00 y 2026-12-31 23:59:59) 
        $startOfYear = Carbon::now()->startOfYear();
        $endOfYear = Carbon::now()->endOfYear();

        // Cuenta la cantidad de registros en el año
        $countThisYear = Fire::whereBetween('created_at', [$startOfYear, $endOfYear])->count(); 
        $nextFire = $countThisYear + 1;

        $counter = str_pad($nextFire, 4, '0', STR_PAD_LEFT);

        return "{$currentYear}-{$entityKey}-{$counter}";
    }
}
