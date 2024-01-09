<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\WomenAccountCompletion;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class WomenAccountCompletionController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'fullname' => 'required',
                'hasbandFullname' => 'required',
                'dateofbirth' => 'required',
                'nationality' => 'required',
                'contactnumber' => 'required',
                'profilePicture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'address' => 'required',
                'emergencycontactinformation' => 'required',
                'occapation' => 'required',
                'educationlevel' => 'required',
                'previouspregnancies' => 'required',
                'bloodtype' => 'required',
                'Weight' => 'required',
                'conceivedate' => 'required',
                'expectedDuedatedeliverbaby' => 'required',
                'preferredlanguage' => 'required',
                'lifestyleandHabits' => 'required',
                'continualillness' => 'required',
                'disability' => 'required',
            ]);

            $womenAccountData = $request->all();

            // Handle image upload for profilePicture
            if ($request->hasFile('profilePicture')) {
                $profilePicture = $request->file('profilePicture');

                // Log information about the image
                Log::info('Profile Picture details:', [
                    'original_name' => $profilePicture->getClientOriginalName(),
                    'extension' => $profilePicture->getClientOriginalExtension(),
                    'size' => $profilePicture->getSize(),
                    'mime_type' => $profilePicture->getMimeType(),
                ]);

                $imagePath = $profilePicture->store('public/profile_pictures');
                $womenAccountData['profilePicture'] = Storage::url($imagePath);
            }

            $womenAccountCompletion = WomenAccountCompletion::create($womenAccountData);

            return response()->json(['message' => 'Women account completion created successfully', 'data' => $womenAccountCompletion], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()], 422);
        }
    }
}
