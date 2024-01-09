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
        Schema::create('clinical_data', function (Blueprint $table) {
            $table->id();
            $table->date('datadate');
            $table->string('weight');
            $table->string('bloodpressure');
            $table->string('bloodsugar');
            $table->string('UltrasoundScan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinical_data');
    }
};
