<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyAlert extends Model
{
    use HasFactory;
    protected $table = 'emergencyalert';
    protected $fillable = [
        // 'pregnancy_id',
        'alert_date',
        'alert_message',
    ];

    // public function pregnancy()
    // {
    //     return $this->belongsTo(Pregnancy::class);
    // }
}
