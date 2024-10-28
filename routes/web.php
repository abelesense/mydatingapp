<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\EditController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\RouletteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [RegistrationController::class, 'showRegistrationForm']);
Route::post('/register', [RegistrationController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/myprofile', [ProfileController::class, 'showProfileForm'])->name('myprofile');
Route::post('/myprofile', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/edit-profile', [ProfileController::class, 'update'])->name('edit.edited');
Route::get('/logout', [ProfileController::class, 'logout'])->name('logout');

Route::get('/add-interests', [InterestController::class, 'showInterestForm'])->name('add-interests');

Route::get('/edit-profile', [EditController::class, 'showEditedForm'])->name('edit-profile');

Route::post('/save-interest', [InterestController::class, 'saveInterest'])->name('saveInterest');

Route::get('/users', [UserController::class, 'showUsers'])->name('users');
Route::get('/profile/{id}', [UserController::class, 'show'])->name('profile.show');

Route::get('/roulette', [RouletteController::class, 'showRoulette'])->name('roulette');
Route::get('/roulette/next', [RouletteController::class, 'getNextProfile'])->name('roulette.next');
Route::post('/roulette/action', [RouletteController::class, 'rouletteAction'])->name('roulette.action');

Route::get('/mylikes', [LikeController::class, 'showLikes'])->name('mylikes');
Route::get('/wholikesme', [LikeController::class, 'whoLikesMe'])->name('wholikesme');

Route::get('/matches', [MatchController::class, 'showMatches'])->name('matches')->middleware('auth');

Route::get('/chat/{user}', [ChatController::class, 'showChat'])->name('chat');
Route::post('/chat/{user}/send', [ChatController::class, 'sendMessage'])->name('chat.send');
