<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Nurse;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class nurseController extends Controller
{
    public function index()
    {
        return Nurse::all();
    }

    public function show($id)
    {
        $nurse = Nurse::find($id);

        if ($nurse) {
            return response()->json(['message' => 'Nurse information displayed successfully', 'data' => $nurse]);
        } else {
            return response()->json(['message' => 'Nurse not found'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'specialization' => 'required',
                'license_number' => 'required',
                'contact_number' => 'required',
                'email' => 'required|email|unique:nurses',
                'hospital_affiliation' => 'required',
                'qualification' => 'required',
                'experience_years' => 'required|numeric',
                'additional_certifications' => 'nullable',
                'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $nurseData = $request->all();

            // Handle image upload for profile_image to Cloudinary
            if ($request->hasFile('profile_image')) {
                $profileImage = $request->file('profile_image');

                // Upload image to Cloudinary
                $cloudinaryResponse = Cloudinary::upload($profileImage->getRealPath(), [
                    'folder' => 'nurse_profile_pictures', // Set the Cloudinary folder
                    'resource_type' => 'auto', // Automatically detect resource type
                ]);

                // Add Cloudinary URL to nurseData
                $nurseData['profile_image'] = $cloudinaryResponse->getSecurePath();
            }

            $nurse = Nurse::create($nurseData);

            return response()->json(['message' => 'Nurse created successfully', 'data' => $nurse], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()], 422);
        }
    }

    public function updateNurse(Request $request, $id)
    {
        try {
            $nurse = Nurse::find($id);

            if (!$nurse) {
                return response()->json(['message' => 'Nurse not found'], 404);
            }

            $request->validate([
                'name' => 'required',
                'specialization' => 'required',
                'license_number' => 'required',
                'contact_number' => 'required',
                'email' => 'required|email|unique:nurses,email,' . $id,
                'hospital_affiliation' => 'required',
                'qualification' => 'required',
                'experience_years' => 'required|numeric',
                'additional_certifications' => 'nullable',
                'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $nurseData = $request->all();

            // Handle image upload for profile_image to Cloudinary
            if ($request->hasFile('profile_image')) {
                $profileImage = $request->file('profile_image');

                // Upload image to Cloudinary
                $cloudinaryResponse = Cloudinary::upload($profileImage->getRealPath(), [
                    'folder' => 'nurse_profile_pictures', // Set the Cloudinary folder
                    'resource_type' => 'auto', // Automatically detect resource type
                ]);

                // Add Cloudinary URL to nurseData
                $nurseData['profile_image'] = $cloudinaryResponse->getSecurePath();
            }

            $nurse->update($nurseData);

            return response()->json(['message' => 'Nurse updated successfully', 'data' => $nurse]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()], 422);
        }
    }

    public function destroy($id)
    {
        $nurse = Nurse::find($id);

        if ($nurse) {
            $nurse->delete();
            return response()->json(['message' => 'Nurse deleted successfully', 'data' => $nurse]);
        } else {
            return response()->json(['message' => 'Nurse not found'], 404);
        }
    }
}
