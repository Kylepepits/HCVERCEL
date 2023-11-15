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
        Schema::create('patient_histories', function (Blueprint $table) {
            $table->string('ph_id')->primary();
            $table->string('ph_changes', 1000)->nullable();
            $table->timestamps();





            $table->string('history_id');
            $table->foreign('history_id')->references('history_id')->on('histories')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->string('attributeVal_id1');
            $table->foreign('attributeVal_id1')->references('attributeVal_id')->on('phr_attribute_values')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->string('attributeVal_id2');
            $table->foreign('attributeVal_id2')->references('attributeVal_id')->on('phr_attribute_values')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_histories');
    }
};
