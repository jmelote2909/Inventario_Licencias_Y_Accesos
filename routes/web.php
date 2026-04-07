<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('equipos', \App\Livewire\EquiposManager::class)
    ->middleware(['auth', 'verified'])
    ->name('equipos');

Route::get('asignaciones', \App\Livewire\AsignacionesManager::class)
    ->middleware(['auth', 'verified'])
    ->name('asignaciones');

Route::get('teletrabajo', \App\Livewire\TeletrabajoManager::class)
    ->middleware(['auth', 'verified'])
    ->name('teletrabajo');

Route::get('db-settings', \App\Livewire\DatabaseSettings::class)
    ->name('db-settings');

require __DIR__.'/auth.php';
