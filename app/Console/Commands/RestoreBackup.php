<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Notifications\RestoreCompletedNotification;
use Illuminate\Support\Facades\Notification;

class RestoreBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:restore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restores the latest backup of the application';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            // Get the latest backup file from the 'Laravel' folder on the 'local' disk
            $disk = Storage::disk('local');
            $backupFiles = $disk->files('Laravel'); // Looking for backups in the 'Laravel' folder

            if (empty($backupFiles)) {
                $this->error('No backups found');
                $this->sendRestoreNotification('No backups found');
                return 1;
            }

            // Get the latest backup file (last in the array)
            $latestBackupFile = end($backupFiles);

            // Unzip the latest backup file
            $zip = new ZipArchive;
            $zipPath = storage_path('app/' . $latestBackupFile);
            
            if (!file_exists($zipPath)) {
                $this->error('Backup file not found: ' . $zipPath);
                $this->sendRestoreNotification('Backup file not found: ' . $zipPath);
                return 1;
            }

            if ($zip->open($zipPath) === true) {
                // Extract the files to the 'restored' folder
                $extractPath = storage_path('app/restored');
                $zip->extractTo($extractPath);
                $zip->close();
                $this->info('Backup files have been restored successfully to: ' . $extractPath);
                $this->sendRestoreNotification('Backup files restored to: ' . $extractPath);
            } else {
                $this->error('Failed to unzip the backup file: ' . $zipPath);
                $this->sendRestoreNotification('Failed to unzip the backup file: ' . $zipPath);
                return 1;
            }

            // Specify the known SQL dump path
            $sqlDumpPath = storage_path('app/restored/db-dumps/mysql-HR_Management_V5.sql');

            // Check if the SQL dump file exists
            if (file_exists($sqlDumpPath)) {
                $this->info('SQL dump file found: ' . $sqlDumpPath);
                $this->restoreDatabase($sqlDumpPath);
                $this->info('Database restored successfully from ' . $sqlDumpPath);
                $this->sendRestoreNotification('Database restored successfully from ' . $sqlDumpPath);
            } else {
                $this->error('SQL dump file not found at: ' . $sqlDumpPath);
                $this->sendRestoreNotification('SQL dump file not found at: ' . $sqlDumpPath);
                return 1;
            }

        } catch (Exception $e) {
            $this->error('An error occurred during the restore process: ' . $e->getMessage());
            $this->sendRestoreNotification('Error occurred: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * Restore the database.
     *
     * @param string $path
     */
    protected function restoreDatabase($path)
    {
        try {
            // Check if it's an SQL dump (for MySQL)
            if (strpos($path, '.sqlite') !== false) {
                $this->info('Restoring SQLite database...');
                $destinationPath = database_path('database.sqlite');
                copy($path, $destinationPath);
            } else {
                $this->info('Restoring MySQL database...');
                $connection = DB::connection();
                $dbName = config('database.connections.mysql.database');

                // Disable foreign key checks to avoid constraints during restore
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                DB::unprepared(file_get_contents($path));
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }
        } catch (Exception $e) {
            $this->error('Failed to restore the database: ' . $e->getMessage());
            $this->sendRestoreNotification('Failed to restore the database: ' . $e->getMessage());
        }
    }

    /**
     * Send an email notification after the restore.
     *
     * @param string $message
     * @return void
     */
    protected function sendRestoreNotification($message)
    {
        $email = 'sophanic1111@gmail.com';
        Notification::route('mail', $email)->notify(new RestoreCompletedNotification($message));
    }
}
