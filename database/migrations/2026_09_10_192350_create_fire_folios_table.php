<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fire_folios', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('year');     

            $table->foreignId('entity_id')
                ->constrained('entities')
                ->cascadeOnDelete();

            $table->unsignedInteger('consecutive_number');
            $table->string('full_key', 50)->unique();
            $table->timestamps();

            $table->unique(['year', 'entity_id', 'consecutive_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fire_folios');
    }
};
