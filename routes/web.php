<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Home page
Route::get('/', function () {
    return redirect()->route('links.create');
})->name('home');

// Guest can create a short URL
Route::get('/links/create', function () {
    return view('pages.links.create');
})->name('links.create');


/*
|--------------------------------------------------------------------------
| Public Short URL Redirect
|--------------------------------------------------------------------------
|
| Anyone can open a generated short URL.
| We will connect this to the ShortUrl controller later.
|
*/

// Example for later:
// Route::get('/{shortCode}', [RedirectController::class, 'redirect']);


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
|
| Everything inside this group requires login.
|
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('pages.dashboard.index');
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Links
    |--------------------------------------------------------------------------
    */

    Route::get('/links', function () {
        return view('pages.links.index');
    })->name('links.index');

    Route::get('/links/favorites', function () {
        return view('pages.links.favorites');
    })->name('links.favorites');

    Route::get('/links/trash', function () {
        return view('pages.links.trash');
    })->name('links.trash');


    /*
    |--------------------------------------------------------------------------
    | Analytics
    |--------------------------------------------------------------------------
    */

    Route::get('/analytics', function () {
        return view('pages.analytics.index');
    })->name('analytics');


    /*
    |--------------------------------------------------------------------------
    | QR Codes
    |--------------------------------------------------------------------------
    */

    Route::get('/qr-codes', function () {
        return view('pages.qr-codes.index');
    })->name('qr-codes');


    /*
    |--------------------------------------------------------------------------
    | Reports
    |--------------------------------------------------------------------------
    */

    Route::get('/reports', function () {
        return view('pages.reports.index');
    })->name('reports');


    /*
    |--------------------------------------------------------------------------
    | Activity Logs
    |--------------------------------------------------------------------------
    */

    Route::get('/activity-logs', function () {
        return view('pages.activity-logs.index');
    })->name('activity-logs');


    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */

    Route::get('/settings', function () {
        return view('pages.settings.index');
    })->name('settings');


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';