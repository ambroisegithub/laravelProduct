<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WomenAccountCompletion extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'hasbandFullname',
        'dateofbirth',

        'nationality',
        'contactnumber',
        'profilePicture',

        'address',
        'emergencycontactinformation',
        'occapation',

        'educationlevel',
        'previouspregnancies',
        'bloodtype',

        'Weight',
        'conceivedate',
        'expectedDuedatedeliverbaby',

        'preferredlanguage',
        'lifestyleandHabits',
        'continualillness',

        'disability',
    ];
}
