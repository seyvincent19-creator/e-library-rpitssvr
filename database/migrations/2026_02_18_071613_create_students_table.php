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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_code')->unique();
            $table->string('full_name', 100);
            $table->enum('gender',['male', 'female','other']);
            $table->date('date_of_birth');
            $table->string('phone', 50)->unique();
            $table->year('enroll_year');

            // ✅ Physical Foreign Key
            $table->foreignId('degree_id')->constrained('degrees')->cascadeOnDelete();

            $table->string('address', 255);
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive', 'graduated', 'suspended'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
