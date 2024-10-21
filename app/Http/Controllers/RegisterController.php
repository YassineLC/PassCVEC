<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BackofficeUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('backoffice.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:backoffice_users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = BackofficeUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        auth('backoffice')->login($user);

        return redirect()->route('backoffice.index');
    }
}
