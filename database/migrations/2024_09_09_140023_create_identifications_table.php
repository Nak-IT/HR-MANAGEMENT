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
        Schema::create('identifications', function (Blueprint $table) {
            $table->id('IdentificationID');
            $table->unsignedBigInteger('EmployeeID');
            $table->string('NationalID', 50)->nullable();
            $table->string('CivilServantID', 50)->nullable();
            $table->string('EmployeeCode', 50)->nullable();
            $table->timestamps();

            $table->foreign('EmployeeID')->references('EmployeeID')->on('personal_info_emp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identifications');
    }
};
