<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movie_dates', function (Blueprint $table) {
            $table->id();
            $table->integer('day');
            $table->string('month');
            $table->string('day_of_week');
            $table->integer('duration');
            $table->string('cinema');
            $table->string('hall');
            $table->string('price');
            $table->string('age_limit')->nullable();
            $table->string('time', 10);
            $table->foreignId('movie_id')->constrained('movies')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_dates');
    }
};
