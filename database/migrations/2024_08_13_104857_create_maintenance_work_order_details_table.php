<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceWorkOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('maintenance_work_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained('maintenance_work_orders')->onDelete('cascade');
            $table->text('description');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 15, 2)->default(0.00);
            $table->decimal('total_price', 15, 2)->default(0.00);
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
        Schema::dropIfExists('maintenance_work_order_details');
    }
}
