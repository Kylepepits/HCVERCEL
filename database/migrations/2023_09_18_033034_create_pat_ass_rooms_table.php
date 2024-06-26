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
        Schema::create('pat_ass_rooms', function (Blueprint $table) {
            $table->string('par_id', 100)->primary();
            $table->string('patient_id', 25);
            $table->string('room_id', 50);
            $table->boolean('isDischarged')->default(false);
            $table->dateTime('dischargeDate')->nullable();

            $table->foreign('patient_id')->references('patient_id')->on('patients')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('room_id')->references('room_id')->on('rooms')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pat_ass_rooms');
    }
};
