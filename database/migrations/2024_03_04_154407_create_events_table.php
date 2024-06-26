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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title_en')->nullable();
            $table->string('title_ru')->nullable();
            $table->string('title_am')->nullable();
            $table->string('cover_picture')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ru')->nullable();
            $table->text('description_am')->nullable();
            $table->text('trailer_url')->nullable();
            $table->text('trailer_file')->nullable();
            $table->string('category');
            $table->boolean('is_visible')->default(true);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(
            )->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
