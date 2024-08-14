<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceWorkOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('maintenance_work_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained();
            $table->foreignId('maintenance_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('vendor_id')->constrained('maintenance_vendors');
            $table->foreignId('assigned_to')->constrained('employees');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled']);
            $table->date('completion_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_work_orders');
    }
}
