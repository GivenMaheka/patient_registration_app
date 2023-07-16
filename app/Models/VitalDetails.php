<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VitalDetails extends Model
{
    use HasFactory; 

    protected $table = "vital_details";

    protected $fillable = [
		'visit_id', 'patient_id','date', 'health', 'onDiet','onDrugs','comments'
	];
}
