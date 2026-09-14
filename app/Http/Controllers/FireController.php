<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFireRequest;
use App\Http\Requests\UpdateFireRequest;
use App\Models\Entity;
use App\Models\Fire;
use App\Models\FireFolio;
use App\Models\Municipality;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FireController extends Controller
{

    public function index(Request $request){
        $entities = Entity::select('id', 'name', 'key')
            ->orderBy('name')
            ->get();

        $fire = null;

        if ($request->filled('search')) {
            $fire = Fire::whereRelation('fireFolio', 'full_key', trim($request->search))
                    ->first();

            if (!$fire) {
                return redirect()->route('fires.index')
                    ->with('searchError', 'No se encontró ningún incendio con la clave proporcionada.');
            }
        }

        return view('fires.index', compact('entities', 'fire'));
    }

    public function store(StoreFireRequest $request){
        DB::transaction(function () use ($request) {
            
            $entityId = $request->validated('entity_id');
            $currentYearFull = (int) Carbon::now()->format('Y');
            $currentYearTwoDigits = Carbon::now()->format('y');

            $lastFolio = FireFolio::where('entity_id', $entityId)
                ->where('year', $currentYearFull)
                ->lockForUpdate()
                ->latest('consecutive_number')
                ->first();

            $nextConsecutive = $lastFolio ? ($lastFolio->consecutive_number + 1) : 1;
            
            $entity = Entity::findOrFail($entityId);
            $counterFormatted = str_pad($nextConsecutive, 4, '0', STR_PAD_LEFT);
            $fullKey = "{$currentYearTwoDigits}-{$entity->key}-{$counterFormatted}";

            $fireFolio = FireFolio::create([
                'year'               => $currentYearFull,
                'entity_id'          => $entityId,
                'consecutive_number' => $nextConsecutive,
                'full_key'           => $fullKey,
            ]);

            $data = $request->validated();
            $dateData = $this->calculateFireDates(
                $request->input('start_date'),
                $request->input('extinction_date')
            );

            $data = array_merge($data, $dateData);
            $data['fire_folio_id'] = $fireFolio->id;

            Fire::create($data);
        });

        return redirect()
            ->route('fires.index')
            ->with('success', 'Incendio y folio registrado correctamente.');
    }

   public function update(UpdateFireRequest $request, Fire $fire){
        $data = $request->validated();

        $dateData = $this->calculateFireDates(
            $request->input('start_date'),
            $request->input('extinction_date')
        );

        $fire->update(array_merge($data, $dateData));

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
        
        $currentYearTwoDigits = Carbon::now()->format('y'); 
        $currentYearFull = (int) Carbon::now()->format('Y');

        // Buscar el último folio registrado para este año y entidad
        $lastFolio = FireFolio::where('entity_id', $entityId)
            ->where('year', $currentYearFull)
            ->latest('consecutive_number')
            ->first();
        
        $nextConsecutive = $lastFolio ? ($lastFolio->consecutive_number + 1) : 1;

        $counter = str_pad($nextConsecutive, 4, '0', STR_PAD_LEFT);

        return "{$currentYearTwoDigits}-{$entity->key}-{$counter}";
    }

    private function calculateFireDates(string $startDateRaw, ?string $extinctionDateRaw): array
    {
        $startDate = Carbon::parse($startDateRaw)->startOfDay();

        if (!empty($extinctionDateRaw)) {
            $extinctionDate = Carbon::parse($extinctionDateRaw)->startOfDay();
        } else {
            $extinctionDate = Carbon::now()->startOfDay();
        }

        $diffDays = (int) $startDate->diffInDays($extinctionDate);
        $durationDays = (int) $diffDays + 1;

        return [
            'start_date'      => $startDate->format('Y-m-d'),
            'extinction_date' => $extinctionDate->format('Y-m-d'),
            'duration_days'   => $durationDays,
        ];
    }
}
