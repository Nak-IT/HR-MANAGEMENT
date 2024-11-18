<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Jobs\BackupJob;
use App\Jobs\RestoreJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Policies\QueueWorkerPolicy;
class BackupController extends Controller
{
    /**
     * Show the backup settings form.
     */
    // public function index()
    // {
    //     // Retrieve the current schedule settings from the database
    //     $schedule = DB::table('backup_schedules')->first();

    //     // Define the base backup directory
    //     $baseBackupDir = storage_path('app/backups');

    //     // Get list of existing backup directories
    //     $backupDirectories = [];
    //     if (file_exists($baseBackupDir)) {
    //         $directories = scandir($baseBackupDir);
    //         foreach ($directories as $dir) {
    //             if ($dir !== '.' && $dir !== '..' && is_dir($baseBackupDir . DIRECTORY_SEPARATOR . $dir)) {
    //                 $backupDirectories[] = $dir;
    //             }
    //         }
    //     }

    //     return view('backup_view.index', compact('schedule', 'backupDirectories'));
    // }

    public function index()
    {
        // Retrieve the current schedule settings from the database
        $schedule = DB::table('backup_schedules')->first();

        // Define the base backup directory
        $baseBackupDir = storage_path('app/backups');

        // Get list of existing backup directories
        $backupDirectories = [];
        if (file_exists($baseBackupDir)) {
            $directories = scandir($baseBackupDir);
            foreach ($directories as $dir) {
                if ($dir !== '.' && $dir !== '..' && is_dir($baseBackupDir . DIRECTORY_SEPARATOR . $dir)) {
                    $backupDirectories[] = $dir;
                }
            }
        }

        // Check if queue worker is running
        $queueWorkerRunning = $this->isQueueWorkerRunning();

        return view('backup_view.index', compact('schedule', 'backupDirectories', 'queueWorkerRunning'));
    }


    /**
     * Run a backup operation.
     */
    public function backup(Request $request)
    {
        $backupDir = $request->input('backup_directory');

        if (!$backupDir) {
            return response()->json(['status' => 'error', 'message' => 'Backup directory is required.'], 400);
        }

        // Clear previous progress
        Cache::forget('backup_progress');

        // Dispatch the backup job
        BackupJob::dispatch($backupDir, 'full');

        return response()->json(['status' => 'success', 'message' => 'Backup started.']);
    }

    /**
     * Run backup as SQL only.
     */
    public function backup_as_sql(Request $request)
    {
        $backupDir = $request->input('backup_directory');

        if (!$backupDir) {
            return response()->json(['status' => 'error', 'message' => 'Backup directory is required.'], 400);
        }

        // Clear previous progress
        Cache::forget('backup_progress');

        // Dispatch the backup job
        BackupJob::dispatch($backupDir, 'sql');

        return response()->json(['status' => 'success', 'message' => 'SQL backup started.']);
    }

    /**
     * Run backup as WinRA format.
     */
    public function backup_as_winra(Request $request)
    {
        $backupDir = $request->input('backup_directory');

        if (!$backupDir) {
            return response()->json(['status' => 'error', 'message' => 'Backup directory is required.'], 400);
        }

        // Clear previous progress
        Cache::forget('backup_progress');

        // Dispatch the backup job
        BackupJob::dispatch($backupDir, 'winra');

        return response()->json(['status' => 'success', 'message' => 'WinRA backup started.']);
    }

    /**
     * Restore from backup.
     */
    public function restore(Request $request)
    {
        $restoreDir = $request->input('restore_directory');

        if (!$restoreDir) {
            return response()->json(['status' => 'error', 'message' => 'Restore directory is required.'], 400);
        }

        // Clear previous progress
        Cache::forget('backup_progress');

        // Dispatch the restore job
        RestoreJob::dispatch($restoreDir, 'full');

        return response()->json(['status' => 'success', 'message' => 'Restore started.']);
    }

    /**
     * Restore from SQL backup.
     */
    public function restore_as_sql(Request $request)
    {
        $restoreDir = $request->input('restore_directory');

        if (!$restoreDir) {
            return response()->json(['status' => 'error', 'message' => 'Restore directory is required.'], 400);
        }

        // Clear previous progress
        Cache::forget('backup_progress');

        // Dispatch the restore job
        RestoreJob::dispatch($restoreDir, 'sql');

        return response()->json(['status' => 'success', 'message' => 'SQL restore started.']);
    }

    /**
     * Restore from WinRA backup.
     */
    public function restore_as_winra(Request $request)
    {
        $restoreDir = $request->input('restore_directory');

        if (!$restoreDir) {
            return response()->json(['status' => 'error', 'message' => 'Restore directory is required.'], 400);
        }

        // Clear previous progress
        Cache::forget('backup_progress');

        // Dispatch the restore job
        RestoreJob::dispatch($restoreDir, 'winra');

        return response()->json(['status' => 'success', 'message' => 'WinRA restore started.']);
    }

    /**
     * Endpoint to get backup progress.
     */
    public function getBackupProgress()
    {
        return response()->json(['progress' => Cache::get('backup_progress', 0)]);
    }

 /**
     * Clean old backups based on type.
     */
    public function clean(Request $request)
    {
        $type = $request->input('type'); // 'zip', 'sql', 'winra'

        if (!$type || !in_array($type, ['zip', 'sql', 'winra'])) {
            return response()->json(['status' => 'error', 'message' => 'Invalid backup type specified.'], 400);
        }

        try {
            // Define the base backup directory
            $baseBackupDir = storage_path('app/backups');

            // Get list of backup directories
            $directories = scandir($baseBackupDir);

            foreach ($directories as $dir) {
                if ($dir !== '.' && $dir !== '..' && is_dir($baseBackupDir . DIRECTORY_SEPARATOR . $dir)) {
                    $backupDirPath = $baseBackupDir . DIRECTORY_SEPARATOR . $dir;

                    // Determine the file extension based on type
                    $extension = '';
                    if ($type === 'zip') {
                        $extension = 'zip';
                    } elseif ($type === 'sql') {
                        $extension = 'sql';
                    } elseif ($type === 'winra') {
                        $extension = 'ra';
                    }

                    // Find all backup files of the specified type
                    $backupFiles = glob("$backupDirPath/backup_full_*.$extension");

                    // Sort files by modification time in descending order
                    usort($backupFiles, function ($a, $b) {
                        return filemtime($b) - filemtime($a);
                    });

                    // Keep the newest file and delete the rest
                    if (count($backupFiles) > 1) {
                        $filesToDelete = array_slice($backupFiles, 1);
                        foreach ($filesToDelete as $file) {
                            @unlink($file);
                        }
                    }
                }
            }

            Log::info("Old $type backups cleaned successfully.");
            return response()->json(['status' => 'success', 'message' => "Old $type backups cleaned successfully."]);

        } catch (\Exception $e) {
            Log::error('Clean Failed: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Clean failed: ' . $e->getMessage()], 500);
        }
    }



    /**
     * Start the Laravel queue worker.
     */
    public function startQueueWorker()
    {
        try {
            $artisan = base_path('artisan');

            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                // Windows OS
                // Start the queue worker in background
                $command = 'start /B php "' . $artisan . '" queue:work --sleep=3 --tries=3';
                pclose(popen($command, 'r'));

                // Set a flag indicating that the worker has been started
                Cache::put('queue_worker_running', true, now()->addDays(1));
            } else {
                // Unix-like OS
                $command = 'nohup php "' . $artisan . '" queue:work --sleep=3 --tries=3 > /dev/null 2>&1 & echo $!';
                $output = [];
                exec($command, $output);

                // Save the process ID (PID) to a file for later use
                $pid = (int)$output[0];
                file_put_contents(storage_path('app/queue_worker.pid'), $pid);
            }

            Log::info('Queue worker started via web interface.');
            return response()->json(['status' => 'success', 'message' => 'Queue worker started successfully.']);
        } catch (\Exception $e) {
            Log::error('Failed to start queue worker: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Failed to start queue worker: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Stop the Laravel queue worker.
     */
    public function stopQueueWorker()
    {
        try {
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                // Windows OS
                // Use WMIC to find the queue worker process
                $command = 'wmic process where (CommandLine like "%php%" and CommandLine like "%artisan%queue:work%") get ProcessId';
                exec($command, $output);

                $pids = [];
                foreach ($output as $line) {
                    if (preg_match('/\d+/', $line, $matches)) {
                        $pids[] = $matches[0];
                    }
                }

                if (!empty($pids)) {
                    foreach ($pids as $pid) {
                        exec("taskkill /F /PID $pid");
                    }
                    // Remove the running flag
                    Cache::forget('queue_worker_running');
                    Log::info('Queue worker stopped via web interface on Windows.');
                    return response()->json(['status' => 'success', 'message' => 'Queue worker stopped successfully.']);
                } else {
                    throw new \Exception('Queue worker process not found.');
                }
            } else {
                // Unix-like OS
                $pidFile = storage_path('app/queue_worker.pid');
                if (file_exists($pidFile)) {
                    $pid = (int)file_get_contents($pidFile);
                    if ($pid) {
                        exec("kill $pid");
                        unlink($pidFile);
                        Log::info('Queue worker stopped via web interface.');
                        return response()->json(['status' => 'success', 'message' => 'Queue worker stopped successfully.']);
                    } else {
                        throw new \Exception('Invalid PID.');
                    }
                } else {
                    throw new \Exception('PID file not found. Cannot stop queue worker.');
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to stop queue worker: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Failed to stop queue worker: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Check if the queue worker is running.
     */
    protected function isQueueWorkerRunning()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Windows OS
            // Check if we have set a flag indicating the worker is running
            return Cache::get('queue_worker_running', false);
        } else {
            // Unix-like OS
            $pidFile = storage_path('app/queue_worker.pid');
            if (file_exists($pidFile)) {
                $pid = (int)file_get_contents($pidFile);
                if ($pid) {
                    $result = shell_exec(sprintf("ps %d", $pid));
                    if (count(preg_split("/\n/", $result)) > 2) {
                        return true;
                    }
                }
            }
            return false;
        }
    }


}
