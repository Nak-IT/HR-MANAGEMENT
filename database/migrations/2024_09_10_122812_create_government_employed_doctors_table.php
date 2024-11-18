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
        Schema::create('government_employed_doctors', function (Blueprint $table) {
            $table->id('government_employed_doctorID');
            $table->unsignedBigInteger('EmployeeID');
            $table->date('StartDate');
            $table->date('EndDate')->nullable();
            $table->date('CurrentPositionDate');
            $table->unsignedBigInteger('PositionID');
            $table->string('EmploymentCategory');
            $table->string('Institution');
            $table->unsignedBigInteger('CategoryEmployeeID');
            $table->unsignedBigInteger('DepartmentID');
            $table->unsignedBigInteger('BuildingID');
            $table->unsignedBigInteger('StatusID');
            $table->timestamps();

            $table->foreign('EmployeeID')->references('EmployeeID')->on('personal_info_Emp');
            $table->foreign('PositionID')->references('PositionID')->on('Positions');
            $table->foreign('CategoryEmployeeID')->references('CategoryEmployeeID')->on('category_employees');
            $table->foreign('DepartmentID')->references('DepartmentID')->on('Departments');
            $table->foreign('BuildingID')->references('BuildingID')->on('Buildings');
            
            $table->foreign('StatusID')->references('StatusID')->on('employment_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('government_employed_doctors');
    }
};
