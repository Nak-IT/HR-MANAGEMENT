<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class BackupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    protected $backupDir;
    protected $type; // 'full', 'sql', or 'winra'

    public function __construct($backupDir, $type)
    {
        $this->backupDir = $backupDir;
        $this->type = $type;
    }

    public function handle()
    {
        try {
            $timestamp = date('Y-m-d_H-i-s');
            $baseBackupDir = storage_path('app/backups');
            $backupDirName = basename($this->backupDir);
            $backupDirPath = $baseBackupDir . DIRECTORY_SEPARATOR . $backupDirName;

            if (!file_exists($backupDirPath)) {
                if (!mkdir($backupDirPath, 0777, true)) {
                    throw new \Exception('Failed to create backup directory: ' . $backupDirPath);
                }
            }

            // Paths for the SQL dump and backup file
            $sqlFilePath = $backupDirPath . DIRECTORY_SEPARATOR . 'backup_full_' . $timestamp . '.sql';

            // Initialize progress
            $this->updateProgress(0);

            // Step 1: Create the SQL dump
            $this->updateProgress(10);

            $dbUser = env('DB_USERNAME', 'root');
            $dbHost = env('DB_HOST', '127.0.0.1');
            $dbPassword = env('DB_PASSWORD', '');
            $dbName = env('DB_DATABASE', 'HR_Management_V5');
            $mysqlDumpPath = env('MYSQLDUMP_PATH', 'mysqldump');

            // Build the dump command
            $dumpCommand = "\"$mysqlDumpPath\" -u $dbUser" . ($dbPassword ? " -p$dbPassword" : "") . " --host=$dbHost $dbName > \"$sqlFilePath\"";

            exec($dumpCommand, $output, $dumpResultCode);

            if ($dumpResultCode !== 0) {
                throw new \Exception('Database dump failed with exit code: ' . $dumpResultCode);
            }

            if ($this->type === 'sql') {
                $this->updateProgress(100);
                Log::info('SQL backup completed successfully.');
                return;
            }

            $this->updateProgress(30);

            // Determine backup file extension
            $extension = $this->type === 'winra' ? 'ra' : 'zip';
            $backupFilePath = $backupDirPath . DIRECTORY_SEPARATOR . 'backup_full_' . $timestamp . '.' . $extension;

            // Step 2: Create the archive
            $zip = new \ZipArchive();
            if ($zip->open($backupFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
                // Add the SQL file
                $zip->addFile($sqlFilePath, 'backup_full_' . $timestamp . '.sql');

                // Add application files
                $this->updateProgress(50);

                $appPath = base_path();
                $excludePaths = ['storage/logs', 'vendor', 'storage/app/backups'];

                $files = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($appPath),
                    \RecursiveIteratorIterator::LEAVES_ONLY
                );

                foreach ($files as $name => $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = substr($filePath, strlen($appPath) + 1);

                        if (!$this->isExcludedPath($relativePath, $excludePaths)) {
                            $zip->addFile($filePath, $relativePath);
                        }
                    }
                }

                $this->updateProgress(80);

                // Close the zip file
                $zip->close();

                // Clean up SQL dump file
                unlink($sqlFilePath);

                $this->updateProgress(100);

                Log::info(ucfirst($this->type) . ' backup completed successfully.');
            } else {
                throw new \Exception('Failed to create the backup file.');
            }
        } catch (\Exception $e) {
            Log::error('Backup Failed: ' . $e->getMessage());
            $this->updateProgress(0); // Reset progress on failure
        }
    }

    protected function updateProgress($progress)
    {
        Cache::put('backup_progress', $progress, now()->addMinutes(10));
    }

    protected function isExcludedPath($relativePath, $excludePaths)
    {
        foreach ($excludePaths as $excludePath) {
            if (strpos($relativePath, $excludePath) === 0) {
                return true;
            }
        }
        return false;
    }
}
