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
            $table->integer('score_case_method');
            $table->integer('score_project_based');
            $table->integer('score_cognitive_task');
            $table->integer('score_cognitive_quiz');
            $table->integer('score_cognitive_uts');
            $table->integer('score_cognitive_uas');
            $table->text('description_case_method');
            $table->text('description_project_based');
            $table->text('description_cognitive_task');
            $table->text('description_cognitive_quiz');
            $table->text('description_cognitive_uts');
            $table->text('description_cognitive_uas');
            $table->string('file_rps');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_k_u7_s');
    }
};
