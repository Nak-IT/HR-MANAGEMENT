<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class RestoreJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    protected $restoreDir;
    protected $type; // 'full', 'sql', or 'winra'

    public function __construct($restoreDir, $type)
    {
        $this->restoreDir = $restoreDir;
        $this->type = $type;
    }

    public function handle()
    {
        try {
            $baseBackupDir = storage_path('app/backups');
            $restoreDirName = basename($this->restoreDir);
            $restoreDirPath = $baseBackupDir . DIRECTORY_SEPARATOR . $restoreDirName;

            if (!file_exists($restoreDirPath)) {
                throw new \Exception('Restore directory does not exist: ' . $restoreDirPath);
            }

            $this->updateProgress(0);

            if ($this->type === 'sql') {
                // Find the latest SQL file
                $sqlFiles = glob("$restoreDirPath/backup_full_*.sql");
                $latestSqlFile = $sqlFiles ? max($sqlFiles) : null;

                if (!$latestSqlFile) {
                    throw new \Exception("No SQL backup files found in the specified directory.");
                }

                $this->updateProgress(50);

                $dbUser = env('DB_USERNAME', 'root');
                $dbHost = env('DB_HOST', '127.0.0.1');
                $dbPassword = env('DB_PASSWORD', '');
                $dbName = env('DB_DATABASE', 'HR_Management_V5');
                $mysqlPath = env('MYSQL_PATH', 'mysql');

                $restoreCommand = "\"$mysqlPath\" -u $dbUser" . ($dbPassword ? " -p$dbPassword" : "") . " --host=$dbHost $dbName < \"$latestSqlFile\"";

                exec($restoreCommand, $output, $restoreResultCode);

                if ($restoreResultCode !== 0) {
                    throw new \Exception('Database restore failed with exit code: ' . $restoreResultCode);
                }

                $this->updateProgress(100);

                Log::info("Database restored successfully from SQL backup: " . $latestSqlFile);
                return;
            }

            // For 'full' and 'winra' restores
            $extension = $this->type === 'winra' ? 'ra' : 'zip';
            $backupFiles = glob("$restoreDirPath/backup_full_*.$extension");
            $latestBackupFile = $backupFiles ? max($backupFiles) : null;

            if (!$latestBackupFile) {
                throw new \Exception("No backup files found in the specified directory.");
            }

            $this->updateProgress(20);

            $zip = new \ZipArchive();
            $restoreTempDir = storage_path('app/restore_temp');

            if (!file_exists($restoreTempDir)) {
                mkdir($restoreTempDir, 0777, true);
            }

            if ($zip->open($latestBackupFile) === TRUE) {
                // Extract SQL file
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $filename = $zip->getNameIndex($i);
                    if (pathinfo($filename, PATHINFO_EXTENSION) === 'sql') {
                        $zip->extractTo($restoreTempDir, $filename);
                        $sqlFilePath = "$restoreTempDir/$filename";
                        break;
                    }
                }
                $zip->close();

                if (!isset($sqlFilePath) || !file_exists($sqlFilePath)) {
                    throw new \Exception("SQL file not found in the backup archive.");
                }
            } else {
                throw new \Exception("Failed to open the backup file for extraction.");
            }

            $this->updateProgress(50);

            // Restore the database from the extracted SQL file
            $dbUser = env('DB_USERNAME', 'root');
            $dbHost = env('DB_HOST', '127.0.0.1');
            $dbPassword = env('DB_PASSWORD', '');
            $dbName = env('DB_DATABASE', 'HR_Management_V5');
            $mysqlPath = env('MYSQL_PATH', 'mysql');

            $restoreCommand = "\"$mysqlPath\" -u $dbUser" . ($dbPassword ? " -p$dbPassword" : "") . " --host=$dbHost $dbName < \"$sqlFilePath\"";

            exec($restoreCommand, $output, $restoreResultCode);

            if ($restoreResultCode !== 0) {
                throw new \Exception('Database restore failed with exit code: ' . $restoreResultCode);
            }

            if ($this->type === 'full' || $this->type === 'winra') {
                $this->updateProgress(70);

                // Extract application files
                if ($zip->open($latestBackupFile) !== TRUE) {
                    throw new \Exception("Failed to open backup file for application files extraction.");
                }

                $appPath = base_path();
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $filename = $zip->getNameIndex($i);
                    if (pathinfo($filename, PATHINFO_EXTENSION) !== 'sql') {
                        $zip->extractTo($appPath, $filename);
                    }
                }
                $zip->close();
            }

            $this->updateProgress(90);

            // Clean up extracted SQL file
            unlink($sqlFilePath);

            $this->updateProgress(100);

            Log::info("System restored successfully from backup: " . $latestBackupFile);
        } catch (\Exception $e) {
            Log::error('Restore Failed: ' . $e->getMessage());
            $this->updateProgress(0); // Reset progress on failure
        }
    }

    protected function updateProgress($progress)
    {
        Cache::put('backup_progress', $progress, now()->addMinutes(10));
    }
}
