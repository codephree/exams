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
        // This migration creates the 'exams' table for storing exam master data
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->integer('duration_minutes');
            $table->integer('total_marks');
            $table->string('created_by'); // could be admin or instructor ID
            $table->string('status')->default('scheduled'); // scheduled, ongoing, completed
            $table->timestamps();
        });

        // Then we add indexes to optimize queries on frequently searched columns
        Schema::table('exams', function (Blueprint $table) {
            $table->index('created_by');
            $table->index('status');
        });

        // Create table for exam questions
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
            $table->text('question_text');
            $table->string('question_type'); // e.g., multiple_choice, true_false, short_answer
            $table->json('options')->nullable(); // for multiple choice questions
            $table->string('correct_answer')->nullable();
            $table->integer('marks');
            $table->timestamps();
        });

        // Create table for student exam attempts
        Schema::create('student_exam_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
            $table->dateTime('started_at');
            $table->dateTime('submitted_at')->nullable();
            $table->integer('score')->nullable();
            $table->string('status')->default('in_progress'); // in_progress, submitted, graded
            $table->timestamps();
        });

        // Create table for student answers
        Schema::create('student_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('student_exam_attempts')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('exam_questions')->onDelete('cascade');
            $table->text('answer_text')->nullable();
            $table->integer('marks_obtained')->nullable();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_questions');
        Schema::dropIfExists('exams');
        Schema::dropIfExists('student_exam_attempts');
        Schema::dropIfExists('student_answers');

    }
};
