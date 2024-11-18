<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBackupSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('backup_schedules', function (Blueprint $table) {
            $table->id();
            $table->time('backup_time');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('backup_schedules');
    }
}
