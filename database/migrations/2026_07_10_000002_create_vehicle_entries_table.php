<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();

            $table->string('job_order_no')->unique();
            $table->date('entry_date');
            $table->string('car_model')->nullable();
            $table->string('plate_number')->nullable();
            $table->string('sma')->nullable();

            $table->decimal('total_amount', 10, 2)->default(0);

            // Signatures stored as PNG files (see storage/app/public/signatures)
            $table->string('customer_signature_path')->nullable();
            $table->string('manager_signature_path')->nullable();

            $table->enum('status', ['draft', 'submitted'])->default('submitted');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['entry_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_entries');
    }
};
