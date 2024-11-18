<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HiredNotMedicalOfficer extends Model
{
    use HasFactory;
    protected $table = 'hired_not_medical_officers'; //មន្ត្រីកិច្ចសន្យា​ឬមន្ត្រីជួល និង ជាវេជ្ជសាស្ត្រ
    protected $primaryKey = 'HiredNotMedicalOfficerID';

    protected $fillable = [
        'EmployeeID',
        'StartDate',
        'EndDate',
        'CurrentPositionDate',
        'PositionID',
        'Institution',
        'SkillID',
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

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'SkillID', 'SkillID');
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
