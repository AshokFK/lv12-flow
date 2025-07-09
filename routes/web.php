<?php

use App\Livewire\Access\ListRolePermission;
use App\Livewire\Flow\ChartItem;
use App\Livewire\Flow\ListHeader;
use App\Livewire\Flow\ListItem;
use App\Livewire\Masalah\ListMasalah;
use App\Livewire\Lokasi\ListLokasi;
use App\Livewire\Proses\ListProses;
use App\Livewire\Qc\ListQc;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Livewire\Komponen\ListKomponen;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::view('/', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::group(['prefix' => 'master'], function () {
        Route::get('/komponen', ListKomponen::class)->name('list.komponen');
        Route::get('/proses', ListProses::class)->name('list.proses');
        Route::get('/qc', ListQc::class)->name('list.qc');
        Route::get('/lokasi', ListLokasi::class)->name('list.lokasi');
    });
    Route::group(['prefix' => 'flow'], function () {
        Route::get('/header', ListHeader::class)->name('list.header');
        Route::get('/item/{header}', ListItem::class)->name('list.item');
        Route::get('/chart/{header}', ChartItem::class)->name('chart.item');
    });
    Route::get('/masalah', ListMasalah::class)->name('list.masalah');
    
    Route::group(['prefix' => 'access'], function () {
        Route::get('/role-permission', ListRolePermission::class)->name('list.role.permission');
    });
});

require __DIR__.'/auth.php';
