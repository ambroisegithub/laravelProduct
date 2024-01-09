<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ClinicalData extends Model
{
    use HasFactory;

    protected $table = 'clinical_data';

    protected $fillable = [
        'datadate',
        'weight',
        'bloodpressure',
        'bloodsugar',
        'UltrasoundScan',
    ];
}
