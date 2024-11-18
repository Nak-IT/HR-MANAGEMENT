<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRestoreAndCleanTimeToBackupSchedulesTable extends Migration
{
    public function up()
    {
        Schema::table('backup_schedules', function (Blueprint $table) {
            $table->time('restore_time')->nullable()->after('backup_time');
            $table->time('clean_time')->nullable()->after('restore_time');
        });
    }

    public function down()
    {
        Schema::table('backup_schedules', function (Blueprint $table) {
            $table->dropColumn(['restore_time', 'clean_time']);
        });
    }
}
