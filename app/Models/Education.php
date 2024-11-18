<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $table = 'education';
    protected $primaryKey = 'EducationID';

    protected $fillable = [
        'EmployeeID',
        'EducationLevel',
        'Country',
        'School',
        'Degree',
        'StartDate',
        'EndDate',
    ];

    protected $casts = [
        'StartDate' => 'date',
        'EndDate' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(PersonalInfoEmp::class, 'EmployeeID', 'EmployeeID');
    }
}
