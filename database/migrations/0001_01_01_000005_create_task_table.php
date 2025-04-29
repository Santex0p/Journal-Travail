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
        Schema::create('t_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('taskName');
            $table->string('taskDescription');

            $table->foreignId('idData')->references('id')->on('t_data')->ondelete('cascade');
            $table->index('idData');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_tasks');
    }
};
