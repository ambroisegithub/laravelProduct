<?php

namespace App\Http\Controllers;

use App\Models\WomenAccountCompletion;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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

            // Handle image upload for profilePicture to Cloudinary
            if ($request->hasFile('profilePicture')) {
                $profilePicture = $request->file('profilePicture');

                // Upload image to Cloudinary
                $cloudinaryResponse = Cloudinary::upload($profilePicture->getRealPath(), [
                    'folder' => 'profile_pictures', // Set the Cloudinary folder
                    'resource_type' => 'auto', // Automatically detect resource type
                ]);

                // Add Cloudinary URL to womenAccountData
                $womenAccountData['profilePicture'] = $cloudinaryResponse->getSecurePath();
            }

            $womenAccountCompletion = WomenAccountCompletion::create($womenAccountData);

            return response()->json(['message' => 'Women account completion created successfully', 'data' => $womenAccountCompletion], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()], 422);
        }
    }

    public function Getall()
    {
        return WomenAccountCompletion::all();
    }

    public function getById($id)
    {
        $account = WomenAccountCompletion::find($id);
        if ($account) {
            return response()->json([
                'messsage' => "The account information display sucuussfully", "data" => $account,

            ]);
        }
    }


    public function destroyAccount($id)
    {

        $account = WomenAccountCompletion::find($id);

        if ($account) {
            WomenAccountCompletion::destroy($id);
            return response()->json([
                'message' => "The account was deleted succussful", 'data' => $account,
            ]);
        } else {
            return response()->json([
                'message' => "No account Fount"
            ], 401);
        }
    }


    public function updateAccount(Request $request, $id)
    {
        $account = WomenAccountCompletion::find($id);

        if (!$account) {
            return response()->json([
                'message' => "No account found"
            ], 404);
        }

        $request->validate([
            'fullname' => 'required|string',
            'hasbandFullname' => 'string',
            'dateofbirth' => 'date',
            'nationality' => 'string',
            'contactnumber' => 'string',
            'profilePicture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'string',
            'emergencycontactinformation' => 'string',
            'occapation' => 'string',
            'educationlevel' => 'string',
            'previouspregnancies' => 'integer',
            'bloodtype' => 'string',
            'Weight' => 'numeric',
            'conceivedate' => 'date',
            'expectedDuedatedeliverbaby' => 'date',
            'preferredlanguage' => 'string',
            'lifestyleandHabits' => 'string',
            'continualillness' => 'string',
            'disability' => 'string',
        ]);

        // Update other fields
        $updateData = [
            'fullname' => $request->input('fullname'),
            'hasbandFullname' => $request->input('hasbandFullname'),
            'dateofbirth' => $request->input('dateofbirth'),

            'nationality' => $request->input('nationality'),
            'contactnumber' => $request->input('contactnumber'),
            'address' => $request->input('address'),

            'emergencycontactinformation' => $request->input('emergencycontactinformation'),
            'occapation' => $request->input('occapation'),
            'educationlevel' => $request->input('educationlevel'),

            'previouspregnancies' => $request->input('previouspregnancies'),
            'bloodtype' => $request->input('bloodtype'),
            'Weight' => $request->input('Weight'),

            'conceivedate' => $request->input('conceivedate'),
            'expectedDuedatedeliverbaby' => $request->input('expectedDuedatedeliverbaby'),
            'preferredlanguage' => $request->input('preferredlanguage'),

            'lifestyleandHabits' => $request->input('lifestyleandHabits'),
            'continualillness' => $request->input('continualillness'),
            'disability' => $request->input('disability'),
        ];

        // Update profile picture if provided
        if ($request->hasFile('profilePicture')) {
            // Delete old profile picture if exists
            if ($account->profilePicture) {
                // You may want to delete the Cloudinary image here as well
                // Cloudinary::destroy($account->cloudinary_public_id);
            }

            // Upload new profile picture to Cloudinary
            $cloudinaryResponse = Cloudinary::upload($request->file('profilePicture')->getRealPath(), [
                'folder' => 'profile_pictures',
                'resource_type' => 'auto',
            ]);

            // Add Cloudinary URL to updateData
            $updateData['profilePicture'] = $cloudinaryResponse->getSecurePath();
        }

        $account->update($updateData);

        return response()->json([
            'message' => "The account was updated successfully", 'data' => $account,
        ]);
    }
}
