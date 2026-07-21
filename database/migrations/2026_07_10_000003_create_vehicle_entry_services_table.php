<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_entry_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_entry_id')->constrained('vehicle_entries')->cascadeOnDelete();

            $table->string('service_name_en');
            $table->string('service_name_ar')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('remarks')->nullable();

            // false = main service row, true = add-on row.
            // Kept in the same table (not split) so totals/reordering stay
            // trivial — a single "SELECT ... WHERE vehicle_entry_id" gives
            // you everything, and scaling to a 3rd row "type" later is just
            // widening this enum, not adding a table.
            $table->boolean('is_addon')->default(false);

            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index(['vehicle_entry_id', 'is_addon']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_entry_services');
    }
};
