<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('tax_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained();
            $table->foreignId('tax_id')->constrained();
            $table->string('transactionable_type');
            $table->unsignedBigInteger('transactionable_id');
            $table->decimal('amount', 15, 2);
            $table->timestamps();

            $table->index(['transactionable_type', 'transactionable_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_transactions');
    }
}
