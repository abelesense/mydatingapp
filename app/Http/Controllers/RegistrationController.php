<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Валидация данных
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'age' => 'required|integer',
            'password' => 'required|string|min:4|confirmed',
            'gender' => 'required|string|max:10',
            'location' => 'required|string|max:255',
            'bio' => 'required|string|max:500',
            'image' => 'required|url',
        ]);

        // Создание пользователя
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

        // Редирект с сообщением об успехе
        return redirect('/')->with('success', 'Registration successful!');
    }
}


