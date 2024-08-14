<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained();
            $table->string('related_entity_type');
            $table->unsignedBigInteger('related_entity_id');
            $table->string('file_name');
            $table->string('file_type');
            $table->string('file_url');
            $table->foreignId('uploaded_by')->constrained('users');
            $table->timestamps();

            $table->index(['related_entity_type', 'related_entity_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
}
