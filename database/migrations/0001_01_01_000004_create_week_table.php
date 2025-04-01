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
        Schema::create('t_weeks', function (Blueprint $table) {
            $table->id();
            $table->string('weeName');
            $table->string('weeStartDate');
            $table->string('weeEndDate');

            $table->foreignId('idData')->references('id')->on('t_data')->ondelete('cascade');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_weeks');
    }
};
