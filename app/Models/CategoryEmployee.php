<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryEmployee extends Model
{
    use HasFactory;

    protected $primaryKey = 'CategoryEmployeeID';
    protected $fillable = ['CategoryEmployeeName'];
    public $timestamps = true;
}
