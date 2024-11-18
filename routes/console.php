<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

app()->booted(function () {
    $schedule = app(Schedule::class);

    // Retrieve schedule times from the backup_schedules table
    $backupSchedule = DB::table('backup_schedules')->first();

    if ($backupSchedule) {
        $backupTime = substr($backupSchedule->backup_time, 0, 5); // Format to "HH:MM"
        $restoreTime = !empty($backupSchedule->restore_time) ? substr($backupSchedule->restore_time, 0, 5) : null;
        $cleanTime = !empty($backupSchedule->clean_time) ? substr($backupSchedule->clean_time, 0, 5) : null;

        Log::info('Loaded schedule times', [
            'backup_time' => $backupTime,
            'restore_time' => $restoreTime,
            'clean_time' => $cleanTime,
        ]);

        // Schedule the backup command
        if (!empty($backupTime)) {
            $schedule->command('backup:run')
                ->dailyAt($backupTime)
                ->withoutOverlapping()
                ->onSuccess(function () {
                    Log::info('Backup completed successfully at: ' . now());
                })
                ->onFailure(function () {
                    Log::error('Backup failed at: ' . now());
                });
        }

        // Schedule the restore command if restore_time is set
        if (!empty($restoreTime)) {
            $schedule->command('backup:restore')
                ->dailyAt($restoreTime)
                ->withoutOverlapping()
                ->onSuccess(function () {
                    Log::info('Restore completed successfully at: ' . now());
                })
                ->onFailure(function () {
                    Log::error('Restore failed at: ' . now());
                });
        }

        // Schedule the clean-up command if clean_time is set
        if (!empty($cleanTime)) {
            $schedule->command('backup:clean')
                ->dailyAt($cleanTime)
                ->withoutOverlapping()
                ->onSuccess(function () {
                    Log::info('Clean-up completed successfully at: ' . now());
                })
                ->onFailure(function () {
                    Log::error('Clean-up failed at: ' . now());
                });
        }
    } else {
        Log::warning('No schedule found in the backup_schedules table.');
    }
});
