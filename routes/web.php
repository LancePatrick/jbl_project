<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/player', function () {
    return view('player');
})->name('player');

// Route::get('/teller', function () {
//     return view('teller');
// })->name('teller');

Route::view('dashboard', 'admin.dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('billiard', 'admin.billiard')
    ->middleware(['auth', 'verified'])
    ->name('billiard');

Route::view('horse', 'admin.horse')
    ->middleware(['auth', 'verified'])
    ->name('horse');

Route::view('pre-match', 'pre-match')
    ->name('pre-match');


Route::view('drag-race', 'drag-race')
    ->middleware(['auth', 'verified'])
    ->name('drag.race');

Route::view('teller', 'admin.teller')
    ->middleware(['auth', 'verified'])
    ->name('teller');

// Route::middleware(['auth', 'verified',])->group(function () {
//     Volt::route('/teller', 'logrohan-board');
// });

    // Route::view('teller-drag', 'teller-drag')
    // ->middleware(['auth', 'verified'])
    // ->name('teller.drag');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
