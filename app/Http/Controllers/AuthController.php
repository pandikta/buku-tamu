<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);



        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $userData = User::where('email', $request->email)->first();

        if (!$userData) {
            return response()->json([
                'message' => 'Email not registered.'
            ], 422);
        } else if (!Hash::check($request->password, $userData->password)) {
            return response()->json([
                'message' => ['Wrong password.']
            ], 422);
        }

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()
            ->json([
                'success' => true,
                'message' => 'Hi ' . $userData->name . ', welcome to home',
            ]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
