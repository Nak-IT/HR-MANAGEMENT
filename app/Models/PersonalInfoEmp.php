<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInfoEmp extends Model
{
    use HasFactory;
    


    protected $table = 'personal_info_emp'; 
    protected $primaryKey = 'EmployeeID';   
    public $incrementing = true;            
    protected $keyType = 'int';   

    protected $fillable = [
        'Emp_as_khmerID',
        'FirstName',
        'LastName',
        'LatinName',
        'Gender',
        'DateOfBirth',
        'Nationality',
        'Phone',
        'Photo',
        'BirthVillage',
        'BirthCommuneWard',
        'BirthDistrict',
        'BirthProvinceID',
        'HouseNumber',
        'GroupNumber',
        'AddressVillage',
        'AddressCommuneWard',
        'AddressDistrict',
        'AddressProvinceID',
    ];

    protected $casts = [
        'DateOfBirth' => 'date',
    ];

    protected $attributes = [
        'Nationality' => 'ខ្មែរ',
    ];

    public function birthProvince()
    {
        return $this->belongsTo(Province::class, 'BirthProvinceID', 'ProvinceID');
    }

    public function addressProvince()
    {
        return $this->belongsTo(Province::class, 'AddressProvinceID', 'ProvinceID');
    }

    // Override the getKeyName method to return the correct primary key name
    public function getKeyName()
    {
        return 'EmployeeID';
    }
}
