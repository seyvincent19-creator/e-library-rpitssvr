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
        Schema::create('return_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrow_book_id')->constrained('borrow_books')->cascadeOnDelete();
            $table->date('return_date')->nullable();
            $table->enum('status', ['borrowed','returned', 'overdue','other'])->default('borrowed');
            // $table->string('status');
            $table->decimal('fine', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_books');
    }
};
