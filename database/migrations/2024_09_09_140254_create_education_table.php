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
        Schema::create('education', function (Blueprint $table) {
            $table->id('EducationID');
            $table->unsignedBigInteger('EmployeeID');
            $table->string('EducationLevel', 255);
            $table->string('Country', 255);
            $table->string('School', 255);
            $table->string('Degree', 255);
            $table->date('StartDate');
            $table->date('EndDate');
            $table->timestamps();

            $table->foreign('EmployeeID')->references('EmployeeID')->on('personal_info_Emp');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education');
    }
};
