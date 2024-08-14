<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_id')->constrained()->onDelete('cascade');
            $table->text('value');
            $table->string('attributable_type');
            $table->unsignedBigInteger('attributable_id');
            $table->timestamps();

            $table->index(['attributable_type', 'attributable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attribute_values');
    }
}
