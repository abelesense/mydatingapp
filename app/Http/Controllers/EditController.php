<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EditController extends Controller
{
    public function showEditedForm()
    {
        $userId = Auth::id();
        $user = User::find($userId);
        return view('edit', ['user' => $user]);
    }
}
