<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackupSchedule extends Model
{
    use HasFactory;

    protected $table = 'backup_schedules';

    protected $fillable = [
        'backup_time',
        'restore_time',
        'clean_time',
    ];
}
