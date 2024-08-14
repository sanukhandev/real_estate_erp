<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained();
            $table->foreignId('investor_id')->constrained('customers');
            $table->foreignId('property_id')->constrained();
            $table->enum('investment_type', ['equity', 'debt', 'joint_venture']);
            $table->decimal('amount_invested', 15, 2);
            $table->decimal('roi', 5, 2)->nullable(); // Return on Investment
            $table->enum('status', ['active', 'matured', 'terminated']);
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
        Schema::dropIfExists('investments');
    }
}
