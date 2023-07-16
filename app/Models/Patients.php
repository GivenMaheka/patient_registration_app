<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Patients extends Model
{
    use HasFactory;

    protected $table = "patients";

    protected $fillable = [
		'patient_id','first_name', 'last_name', 'birth_date','email','gender'
    ];
}
