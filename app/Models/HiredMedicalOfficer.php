<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HiredMedicalOfficer extends Model
{
    use HasFactory;

    protected $table = 'hired_medical_officers'; //មន្ត្រីកិច្ចសន្យា​ឬមន្ត្រីជួល និង ជាវេជ្ជសាស្ត្រ
    protected $primaryKey = 'HiredMedicalOfficerID';

    protected $fillable = [
        'EmployeeID',
        'StartDate',
        'EndDate',
        'CurrentPositionDate',
        'PositionID',
        'Institution',
        'DepartmentID',
        'BuildingID',
        'CategoryEmployeeID',//ប្រភេទបុគ្គលិក
        'StatusID',//ស្ថានភាពមន្ត្រីកិច្ចសន្យា​ឬមន្ត្រីជួល
    ];

    protected $casts = [
        'StartDate' => 'date',
        'CurrentPositionDate' => 'date',
        'EndDate' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(PersonalInfoEmp::class, 'EmployeeID', 'EmployeeID');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'PositionID', 'PositionID');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'DepartmentID', 'DepartmentID');
    }

    public function building()
    {
        return $this->belongsTo(Building::class, 'BuildingID', 'BuildingID');
    }

    public function categoryEmployee()
    {
        return $this->belongsTo(CategoryEmployee::class, 'CategoryEmployeeID', 'CategoryEmployeeID');
    }

    public function status()
    {
        return $this->belongsTo(EmploymentStatus::class, 'StatusID', 'StatusID');
    }
}
