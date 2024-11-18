<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GovernmentEmployedDoctor extends Model
{
    use HasFactory;

    protected $table = 'government_employed_doctors';
    protected $primaryKey = 'government_employed_doctorID';

    protected $fillable = [
        'EmployeeID',
        'StartDate',
        'EndDate',
        'CurrentPositionDate',
        'PositionID',
        'EmploymentCategory',
        'Institution',
        'DepartmentID',
        'BuildingID',
        'CategoryEmployeeID',//ប្រភេទបុគ្គលិក
        'StatusID',
    ];

    protected $casts = [
        'StartDate' => 'date',
        'EndDate' => 'date',
        'CurrentPositionDate' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(PersonalInfoEmp::class, 'EmployeeID');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'PositionID');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'DepartmentID');
    }

    public function building()
    {
        return $this->belongsTo(Building::class, 'BuildingID');
    }

    public function categoryEmployee()
    {
        return $this->belongsTo(CategoryEmployee::class, 'CategoryEmployeeID');
    }

    public function status()
    {
        return $this->belongsTo(EmploymentStatus::class, 'StatusID');
    }
}
