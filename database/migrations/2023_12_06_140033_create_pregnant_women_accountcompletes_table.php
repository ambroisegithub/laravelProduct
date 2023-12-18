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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('hasbandFullname');
            $table->date('dateofbirth');
            $table->string('nationality');
            $table->string('contactnumber');
            $table->string('profilePicture')->nullable();
            $table->text('address');
            $table->text('emergencycontactinformation');
            $table->string('occapation');
            $table->string('educationlevel');
            $table->integer('previouspregnancies');
            $table->string('bloodtype');
            $table->decimal('Weight', 8, 2);
            $table->date('conceivedate');
            $table->date('expectedDuedatedeliverbaby');
            $table->string('preferredlanguage');
            $table->string('lifestyleandHabits');
            $table->string('continualillness');
            $table->string('disability');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
