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
        Schema::create('hired_not_medical_officers', function (Blueprint $table) {
            $table->id('HiredNotMedicalOfficerID');
            $table->unsignedBigInteger('EmployeeID');
            $table->date('StartDate');
            $table->date('EndDate')->nullable();
            $table->date('CurrentPositionDate');
            $table->unsignedBigInteger('PositionID');

            $table->string('Institution');
            $table->unsignedBigInteger('SkillID');
            $table->unsignedBigInteger('BuildingID');
            $table->unsignedBigInteger('StatusID');
            $table->unsignedBigInteger('CategoryEmployeeID');
            $table->timestamps();

            $table->foreign('EmployeeID')->references('EmployeeID')->on('personal_info_Emp');
            $table->foreign('PositionID')->references('PositionID')->on('Positions');
            $table->foreign('SkillID')->references('SkillID')->on('Skills');
            $table->foreign('BuildingID')->references('BuildingID')->on('Buildings');
            
            $table->foreign('StatusID')->references('StatusID')->on('employment_statuses');
            $table->foreign('CategoryEmployeeID')->references('CategoryEmployeeID')->on('category_employees');
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hired_not_medical_officers');
    }
};
