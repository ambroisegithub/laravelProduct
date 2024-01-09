<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller

{
    public function create(Request $request)

    {
        try {
            $request->validate([
                'fullname' => 'required|string',
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

            $accountData = $request->all();
            $requiredFields = ['fullname', 'hasbandFullname', 'dateofbirth', 'nationality', 'contactnumber', 'address', 'emergencycontactinformation', 'occapation', 'educationlevel', 'previouspregnancies', 'bloodtype', 'Weight', 'conceivedate', 'expectedDuedatedeliverbaby', 'preferredlanguage', 'lifestyleandHabits', 'continualillness', 'disability'];

            foreach ($requiredFields as $field) {
                if (!isset($accountData[$field])) {
                    return response()->json(['message' => 'Missing required field: ' . $field], 422);
                }
            }
            // Handle image upload
            if ($request->hasFile('profilePicture')) {
                $image = $request->file('profilePicture');

                // Log information about the image
                Log::info('Image details:', [
                    'original_name' => $image->getClientOriginalName(),
                    'extension' => $image->getClientOriginalExtension(),
                    'size' => $image->getSize(),
                    'mime_type' => $image->getMimeType(),
                ]);

                $imagePath = $image->store('public/profiles');
                $accountData['profilePicture'] = Storage::url($imagePath);
            }

            $account = Account::create($accountData);

            return response()->json(['message' => 'Account created successfully', 'data' => $account], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()], 422);
        }
    }

    public function Getall()
    {
        return Account::all();
    }

    public function getById($id)
    {
        $account = Account::find($id);
        if ($account) {
            return response()->json([
                'messsage' => "The account information display sucuussfully", "data" => $account,

            ]);
        }
    }


    public function destroyAccount($id)
    {

        $account = Account::find($id);

        if ($account) {
            Account::destroy($id);
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
        $account = Account::find($id);

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
                Storage::delete($account->profilePicture);
            }

            // Store new profile picture
            $path = $request->file('profilePicture')->store('profile_pictures');
            $updateData['profilePicture'] = $path;
        }

        $account->update($updateData);

        return response()->json([
            'message' => "The account was updated successfully", 'data' => $account,
        ]);
    }
}
