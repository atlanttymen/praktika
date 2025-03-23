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
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Название события
            $table->text('description')->nullable(); // Описание события
            $table->dateTime('start_time'); // Время начала события
            $table->dateTime('end_time'); // Время окончания события
            $table->string('location')->nullable(); // Место проведения события (если нужно)
            $table->boolean('is_all_day')->default(false); // Флаг для события на весь день
            $table->timestamps(); // Временные метки для created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendars');
    }
};
