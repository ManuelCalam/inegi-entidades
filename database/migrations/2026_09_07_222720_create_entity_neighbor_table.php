<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entity_neighbor', function (Blueprint $table) {
            $table->id();
            
            // Entidad principal
            $table->foreignId('entity_id')
                  ->constrained('entities')
                  ->cascadeOnDelete();

            // Entidad colindante (vecino)
            $table->foreignId('neighbor_entity_id')
                  ->constrained('entities')
                  ->cascadeOnDelete();

            // Evita que se duplique exactamente la misma relación
            $table->unique(['entity_id', 'neighbor_entity_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entity_neighbor');
    }
};