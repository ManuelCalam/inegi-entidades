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
        Schema::create('fires', function (Blueprint $table) {
            $table->id();
            $table->timestamp('reported_at');
            $table->string('fire_key')->unique();
            $table->date('start_date');
            $table->date('extinction_date')->nullable();
            $table->integer('duration_days');
            $table->string('fire_status');
            $table->decimal('control_percentage', 5, 2)->default(0.00);
            $table->decimal('extinction_percentage', 5, 2)->default(0.00);
            $table->timestamps();

            $table->foreignId('entity_id')
                ->nullable()
                ->constrained('entities')
                ->nullOnDelete();

            $table->foreignId('municipality_id')
                ->nullable()
                ->constrained('municipalities')
                ->nullOnDelete();

            $table->foreignId('vegetation_type_id')
                ->nullable()
                ->constrained('vegetation_types')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fires');
    }
};
