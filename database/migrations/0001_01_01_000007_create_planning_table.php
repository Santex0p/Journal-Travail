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
        Schema::create('t_planning', function (Blueprint $table) {
            $table->id();
            $table->string('plaHours');
            $table->string('plaDescription');
            $table->string('plaLinks');

            $table->foreignId('idTask')->references('id')->on('t_tasks')->ondelete('cascade');
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
