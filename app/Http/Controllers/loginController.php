<?php

namespace App\Http\Controllers;

use App\Models\Resident;


use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Http\Response;
use Auth;

class loginController extends Controller
{
    public function username()
    {
        return 'resident_userName';
    }

    public function loginResident(request $request)
    {
        $request->validate([
            'resident_userName' => 'required',
            'resident_password' => 'required',
        ]);


        $credentials = [
            'resident_userName' => $request->input('resident_userName'),
            'password' => $request->input('resident_password'),
        ];
        try {


            if (Auth::guard('custom')->attempt($credentials)) {
                $resident = resident::where('resident_userName', $request['resident_userName'])->first();
                $user = Auth::user();
                $token = $user->createToken('api_token')->plainTextToken;
                return response()->json([
                    'token' => $token,
                    'resident_id' => $resident['resident_id'],
                    'role' => $resident['role'],
                    'resident_fName' => $resident['resident_fName'],
                    'resident_lName' => $resident['resident_lName'],
                    'department_id' => $resident['department_id']
                ], 200);
            }
        } catch (ValidationException $e) {
            return response()->json(['error' => 'login error'], 422);
        }

        return response()->json(['error' => 'invalid credentials'], 401);
    }




    public function logoutRes(request $request)
    {
        auth('custom')->logout();
        $request->user()->currentAccessToken()->delete();

        return response()->json('logged out');
    }
}
