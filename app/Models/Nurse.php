<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    use HasFactory;
    protected $table = 'nurse';

    protected $fillable = [
        // 'user_id',
        'name',
        'specialization',
        'license_number',
        'contact_number',
        'email',
        'hospital_affiliation',
        'qualification',
        'experience_years',
        'additional_certifications',
        'profile_image',
    ];

    // Relationships
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // public function pregnancyRecords()
    // {
    //     return $this->hasMany(PregnancyRecord::class);
    // }
}
