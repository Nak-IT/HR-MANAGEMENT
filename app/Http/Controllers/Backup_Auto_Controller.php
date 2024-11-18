<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Output\BufferedOutput;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RestoreCompletedNotification;
use Illuminate\Support\Facades\Mail;
class Backup_Auto_Controller extends Controller
{
    //
    public function index()
    {
        // Retrieve the current schedule settings from the database
        $schedule = DB::table(table: 'backup_schedules')->first();

        return view('backup_view.index_Auto', compact('schedule'));
    }


    public function updateSchedule(Request $request)
    {
        $request->validate([
            'backup_time' => 'required|date_format:H:i',
            'restore_time' => 'nullable|date_format:H:i',
            'clean_time' => 'nullable|date_format:H:i',
        ]);

        // Update or insert the schedule into the database
        DB::table('backup_schedules')->updateOrInsert(
            ['id' => 1],
            [
                'backup_time' => $request->backup_time,
                'restore_time' => $request->restore_time,
                'clean_time' => $request->clean_time,
                'updated_at' => now(),
            ]
        );

        // Log the schedule update
        Log::info('Backup schedule updated: ', [
            'backup_time' => $request->backup_time,
            'restore_time' => $request->restore_time,
            'clean_time' => $request->clean_time,
        ]);

        return redirect()->back()->with('status', 'Backup schedule updated successfully!');
    }
}
