<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained();
            $table->enum('type', ['residential', 'commercial', 'industrial', 'land']);
            $table->foreignId('address_id')->nullable()->constrained();
            $table->foreignId('owner_id')->constrained('customers');
            $table->decimal('size', 8, 2);
            $table->enum('status', ['available', 'sold', 'leased', 'under_construction']);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->decimal('lease_price', 10, 2)->nullable();
            $table->date('listed_date')->nullable();
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
        Schema::dropIfExists('properties');
    }
}
