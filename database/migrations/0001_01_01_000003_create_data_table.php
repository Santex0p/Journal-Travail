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
            $table->string('datStartDate');
            $table->string('datEndDate');
            $table->string('datNbWeeks');
            $table->string('datNbHour');
            $table->string('datNbPeriod');

            $table->foreignId('email')->references('email')->on('users')->ondelete('cascade');
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
