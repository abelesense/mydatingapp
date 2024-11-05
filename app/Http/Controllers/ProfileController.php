<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function showProfileForm()
    {
        $user = auth()->user();
        $interests = $user->interests; // Получаем интересы пользователя через связь

        return view('profile.index', [
            'user' => $user,
            'interests' => $interests
        ]);
    }

    public function update(UpdateProfileRequest $request)
    {
        $userId = Auth::id();
        $user = User::find($userId);
        $user->username = $request->username;
        $user->age = $request->age;
        $user->bio = $request->bio;
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function logout()
    {
        Auth::logout();

        // Перенаправление на главную страницу после выхода
        return redirect('/')->with('success', 'You have been logged out successfully!');
    }

}
