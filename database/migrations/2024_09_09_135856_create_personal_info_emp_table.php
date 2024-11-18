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
        Schema::create('personal_info_emp', function (Blueprint $table) {
            $table->id('EmployeeID');
            $table->string('Emp_as_khmerID', 255);
            $table->string('FirstName', 255);
            $table->string('LastName', 255);
            $table->string('LatinName', 255)->nullable();
            $table->string('Gender', 10);
            $table->date('DateOfBirth')->nullable();
            $table->string('Nationality', 50)->default('Khmer');
            $table->string('Phone', 20);
            $table->string('Photo', 255)->nullable();

            // Address and Birthplace related fields
            $table->string('BirthVillage', 255);
            $table->string('BirthCommuneWard', 255);
            $table->string('BirthDistrict', 255);
            $table->unsignedBigInteger('BirthProvinceID');

            $table->string('HouseNumber', 50);
            $table->string('GroupNumber', 50);
            $table->string('AddressVillage', 255);
            $table->string('AddressCommuneWard', 255);
            $table->string('AddressDistrict', 255);
            $table->unsignedBigInteger('AddressProvinceID');
            
            // Timestamps for created_at and updated_at
            $table->timestamps();

            $table->foreign('BirthProvinceID')
                  ->references('ProvinceID')->on('provinces')
                  ->onDelete('cascade');
            $table->foreign('AddressProvinceID')
                  ->references('ProvinceID')->on('provinces')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_info_emp');
    }
};
