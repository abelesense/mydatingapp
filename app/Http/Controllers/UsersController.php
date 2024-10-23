<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
class UsersController extends Controller
{
    public function showUsers()
    {
        $currentUserId = Auth::id();
        $users = User::where('id', '!=', $currentUserId)->get();

        return view('users.users', ['users' => $users]);
    }

}
