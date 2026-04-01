<?php

use App\Http\Controllers\AllUsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Route::get('/Users/login',    [AllUsersController::class, 'showLogin'])->name('users.login');
Route::post('/Users/login',   [AllUsersController::class, 'login'])->name('users.login.post');
Route::get('/Users/logout',   [AllUsersController::class, 'logout'])->name('users.logout');

// Registration
Route::get('/Users',          [AllUsersController::class, 'index'])->name('users.index');
Route::get('/Users/create',   [AllUsersController::class, 'create'])->name('users.create');
Route::post('/Users/create',  [AllUsersController::class, 'store'])->name('users.store');

// Dashboard
Route::get('/Users/dashboard', [AllUsersController::class, 'dashboard'])->name('users.dashboard');

// Post routes
Route::post('/Users/addpost',          [AllUsersController::class, 'addpost'])->name('users.addpost');
Route::get('/Users/editpost/{id}',     [AllUsersController::class, 'editpost'])->name('users.editpost');
Route::post('/Users/updatepost/{id}',  [AllUsersController::class, 'updatepost'])->name('users.updatepost');
Route::get('/Users/deletepost/{id}',   [AllUsersController::class, 'deletepost'])->name('users.deletepost');
