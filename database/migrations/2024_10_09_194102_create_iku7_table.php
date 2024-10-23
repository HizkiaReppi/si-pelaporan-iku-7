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
        Schema::create('iku7', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('department_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('period_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->integer('score_case_method')->nullable();
            $table->integer('score_project_based')->nullable();
            $table->integer('score_cognitive_task')->nullable();
            $table->integer('score_cognitive_quiz')->nullable();
            $table->integer('score_cognitive_uts')->nullable();
            $table->integer('score_cognitive_uas')->nullable();
            $table->text('description_case_method')->nullable();
            $table->text('description_project_based')->nullable();
            $table->text('description_cognitive_task')->nullable();
            $table->text('description_cognitive_quiz')->nullable();
            $table->text('description_cognitive_uts')->nullable();
            $table->text('description_cognitive_uas')->nullable();
            $table->string('file_rps')->nullable();
            $table->enum('status_verifikasi', ['pending', 'approved', 'rejected', 'draft'])->default('draft');
            $table->text('deskripsi_verifikasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iku7');
    }
};
