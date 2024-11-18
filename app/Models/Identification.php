<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Identification extends Model
{
    use HasFactory;

    protected $primaryKey = 'IdentificationID';

    protected $fillable = [
        'EmployeeID',
        'NationalID',
        'CivilServantID',
        'EmployeeCode',
    ];

    public function employee()
    {
        return $this->belongsTo(PersonalInfoEmp::class, 'EmployeeID', 'EmployeeID');
    }
}
