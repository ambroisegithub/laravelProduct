<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
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
        'dateofbirth',
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
        'contactnumber',
        'continualillness',
        'disability'

    ];
}
