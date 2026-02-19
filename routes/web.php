<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');

Route::get('/login', function (Request $request) {
    return view('app', [
        'title' => 'Авторизация',
        'appData' => [
            'page' => 'login',
            'csrfToken' => csrf_token(),
            'hasLoginError' => $request->session()->get('errors')?->has('login') ?? false,
            'oldLogin' => (string) old('login', ''),
            'loginAction' => route('login.store'),
        ],
    ]);
})
    ->middleware('guest')
    ->name('login');

Route::get('/dashboard', function (Request $request) {
    $user = $request->user();

    abort_if($user === null, 401);

    return view('app', [
        'title' => 'Dashboard',
        'appData' => [
            'page' => 'dashboard',
            'csrfToken' => csrf_token(),
            'userName' => $user->name,
            'logoutAction' => route('logout'),
            'shopsUrl' => route('shops.index', absolute: false),
        ],
    ]);
})
    ->middleware('auth')
    ->name('dashboard');
