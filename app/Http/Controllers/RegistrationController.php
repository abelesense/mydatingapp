<?php
namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'age' => $validated['age'],
            'password' => Hash::make($validated['password']),
            'gender' => $validated['gender'],
            'location' => $validated['location'],
            'bio' => $validated['bio'],
            'image' => $validated['image'],
        ]);

        return redirect('/')->with('success', 'Registration successful!');
    }
}




