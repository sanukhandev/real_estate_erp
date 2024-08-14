<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained();
            $table->foreignId('property_id')->constrained();
            $table->string('requestor_type'); // This will store the type (User or Customer)
            $table->unsignedBigInteger('requestor_id'); // This will store the ID of the requestor
            $table->text('description');
            $table->enum('status', ['open', 'in_progress', 'completed', 'cancelled']);
            $table->enum('priority', ['low', 'medium', 'high']);
            $table->timestamps();
            $table->index(['requestor_type', 'requestor_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
}
