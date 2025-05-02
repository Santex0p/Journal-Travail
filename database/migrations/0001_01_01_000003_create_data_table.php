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
        Schema::create('t_data', function (Blueprint $table) {
            $table->id();
            $table->string('datModule');
            $table->string('datName');
            $table->string('datClass');
            $table->string('datPlace');
            $table->date('datStartDate');
            $table->date('datEndDate');
            $table->integer('datNbWeeks');
            $table->integer('datNbHour')->nullable();
            $table->integer('datNbPeriod')->nullable();

            $table->foreignId('idUser')->references('id')->on('users')->onDelete('cascade');
            $table->index('idUser');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_data');
    }
};
