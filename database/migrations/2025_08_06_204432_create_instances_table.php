<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('instances', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('patient_estudio_id');
            $table->index('patient_estudio_id');
            $table->foreign('patient_estudio_id')->references('id')->on('patient_estudios');

            $table->string('instance_uid')->nullable();
            $table->string('image_path')->nullable();
            $table->string('pdf_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instances');
    }
};
