<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('billiard', 'billiard')
    ->middleware(['auth', 'verified'])
    ->name('billiard');

Route::view('horse', 'horse')
    ->middleware(['auth', 'verified'])
    ->name('horse');

Route::view('pre', 'pre')
    ->middleware(['auth', 'verified'])
    ->name('pre');

/* ✅ NEW: Drag Race page */
Route::view('drag-race', 'drag-race')
    ->middleware(['auth', 'verified'])
    ->name('drag.race');

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
