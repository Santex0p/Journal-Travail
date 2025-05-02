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
        Schema::create('t_journal', function (Blueprint $table) {
            $table->id();
            $table->integer('jouHours');
            $table->string('jouDescription')->nullable();
            $table->string('jouLinks')->nullable();
            $table->string('taskIndex');

            $table->foreignId('idTask')->references('id')->on('t_tasks')->onDelete('cascade');
            $table->index('idTask');
            $table->foreignId('idProject')->references('id')->on('t_data')->onDelete('cascade');
            $table->index('idProject');
            $table->foreignId('idWeeks')->constrained('t_weeks')->onDelete('cascade');
            $table->index('idWeeks');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_journal');
    }
};
