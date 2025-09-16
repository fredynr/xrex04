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
        Schema::create('patient_estudios', function (Blueprint $table) {
            $table->id();
            $table->string('study_name')->nullable();
            $table->string('image_referral')->nullable();
            $table->text('tech_description')->nullable();
            $table->string('study_id_orthanc')->nullable();
            $table->text('reading')->nullable();
            $table->string('study_state')->nullable();
            $table->string('priority', 20)->nullable();
            $table->text('reason_for_return')->nullable();

            $table->unsignedBigInteger('exam_id');
            $table->index('exam_id');
            $table->foreign('exam_id')->references('id')->on('exams');
            
            $table->unsignedBigInteger('patient_id');
            $table->index('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('specialist_user_id')->nullable();
            $table->index('specialist_user_id');
            $table->foreign('specialist_user_id')->references('id')->on('users');

            $table->unsignedBigInteger('transcriber_user_id')->nullable();
            $table->index('transcriber_user_id');
            $table->foreign('transcriber_user_id')->references('id')->on('users');

            // Campo autoreferenciado para estudios devueltos
            $table->unsignedBigInteger('estudio_parent_id')->nullable();
            $table->foreign('estudio_parent_id')->references('id')->on('patient_estudios')->onDelete('set null');

            $table->dateTime('date_realized')->nullable();
            $table->dateTime('date_audio')->nullable();
            $table->dateTime('date_transcriber')->nullable();
            $table->dateTime('date_finalized')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_estudios');
    }
};
