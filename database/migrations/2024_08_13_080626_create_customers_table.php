<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained();
            $table->enum('type', ['individual', 'business']);
            $table->string('email')->unique();
            $table->string('phone_primary');
            $table->string('phone_secondary')->nullable();
            $table->string('phone_tertiary')->nullable();
            $table->foreignId('address_id')->nullable()->constrained();
            $table->string('tax_id')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
