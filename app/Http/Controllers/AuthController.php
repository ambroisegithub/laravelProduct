<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([

            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|confirmed'
        ]);
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),

        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function Login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required'
        ]);

        // Find the user by email
        $user = User::where('email', $fields['email'])->first();

        // Check if the user exists and the password is correct
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad credentials'
            ], 401);
        }

        // If the user exists and the password is correct, generate a new token
        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function destroyAccount($id)
    {

        $account = User::find($id);

        if ($account) {
            User::destroy($id);
            return response()->json([
                'message' => "The account was deleted succussful", 'data' => $account,
            ]);
        } else {
            return response()->json([
                'message' => "No account Fount"
            ], 401);
        }
    }

    public function deleteAll()
    {
        User::truncate(); // Deletes all records from the products table
        return response()->json(['message' => 'All Users deleted successfully']);
    }
    public function Getall()
    {
        return User::all();
    }


    public function updateUser(Request $request, $id)
    {
        $User = User::find($id);

        if (!$User) {
            return response(['message' => 'User not found'], 404);
        }

        $fields = $request->validate([

            'name' => 'required|string',
            'email' => 'required|string',
        ]);

        $User->update($fields);

        return response(['User' => $User], 200);
    }
    public function logout(Request $request)
    {
        $user = $request->user();

        // Check if the user has a valid token before revoking it
        if ($user->currentAccessToken()) {
            $user->tokens()->delete();
            return response(['message' => 'Logged out successfully']);
        } else {
            return response(['message' => 'Invalid token or user not authenticated'], 401);
        }
    }
}
