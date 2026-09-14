<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ShortUrlController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Home / Landing Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');


/*
|--------------------------------------------------------------------------
| Public Create Short URL
|--------------------------------------------------------------------------
*/

Route::get('/links/create', [
    ShortUrlController::class,
    'create'
])->name('links.create');

Route::post('/links', [
    ShortUrlController::class,
    'store'
])->name('links.store');


/*
|--------------------------------------------------------------------------
| Public Guest QR Code
|--------------------------------------------------------------------------
|
| These routes are for the public landing page.
| Guest QR codes are stored in the session and are not saved
| in the authenticated user's QR code database table.
|
*/

Route::post('/qr-codes/guest/generate', [
    QrCodeController::class,
    'generateGuest'
])->name('qr-codes.guest.generate');

Route::get('/qr-codes/guest/download', [
    QrCodeController::class,
    'downloadGuest'
])->name('qr-codes.guest.download');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Links
    |--------------------------------------------------------------------------
    */

    Route::get('/links', [
        ShortUrlController::class,
        'index'
    ])->name('links.index');


    /*
    |--------------------------------------------------------------------------
    | Favorites
    |--------------------------------------------------------------------------
    */

    Route::get('/links/favorites', [
        ShortUrlController::class,
        'favorites'
    ])->name('links.favorites');

    Route::post('/links/{shortUrl}/favorite', [
        ShortUrlController::class,
        'toggleFavorite'
    ])->name('links.favorite');


    /*
    |--------------------------------------------------------------------------
    | Trash
    |--------------------------------------------------------------------------
    */

    Route::get('/links/trash', [
        ShortUrlController::class,
        'trash'
    ])->name('links.trash');

    Route::delete('/links/{shortUrl}', [
        ShortUrlController::class,
        'destroy'
    ])->name('links.destroy');

    Route::patch('/links/trash/{shortUrl}/restore', [
        ShortUrlController::class,
        'restore'
    ])->name('links.restore');

    Route::delete('/links/trash/{shortUrl}/force-delete', [
        ShortUrlController::class,
        'forceDelete'
    ])->name('links.force-delete');

    Route::delete('/links/trash/empty', [
        ShortUrlController::class,
        'emptyTrash'
    ])->name('links.empty-trash');


    /*
    |--------------------------------------------------------------------------
    | Analytics
    |--------------------------------------------------------------------------
    */

    Route::get('/analytics', [
        AnalyticsController::class,
        'index'
    ])->name('analytics');


    /*
    |--------------------------------------------------------------------------
    | QR Codes
    |--------------------------------------------------------------------------
    */

    Route::get('/qr-codes', [
        QrCodeController::class,
        'index'
    ])->name('qr-codes');

    Route::post('/qr-codes/generate', [
        QrCodeController::class,
        'generate'
    ])->name('qr-codes.generate');

    Route::get('/qr-codes/{qrCode}/download/png', [
        QrCodeController::class,
        'downloadPng'
    ])->name('qr-codes.download.png');

    Route::get('/qr-codes/{qrCode}/download/svg', [
        QrCodeController::class,
        'downloadSvg'
    ])->name('qr-codes.download.svg');

    Route::delete('/qr-codes/{qrCode}', [
        QrCodeController::class,
        'destroy'
    ])->name('qr-codes.destroy');


    /*
    |--------------------------------------------------------------------------
    | Reports
    |--------------------------------------------------------------------------
    */

    Route::get('/reports', [
        ReportController::class,
        'index'
    ])->name('reports');

    Route::post('/reports/generate', [
        ReportController::class,
        'generate'
    ])->name('reports.generate');

    Route::get('/reports/{report}/download', [
        ReportController::class,
        'download'
    ])->name('reports.download');

    Route::delete('/reports/{report}', [
        ReportController::class,
        'destroy'
    ])->name('reports.destroy');


    /*
    |--------------------------------------------------------------------------
    | Activity Logs
    |--------------------------------------------------------------------------
    */

    Route::get('/activity-logs', [
        ActivityLogController::class,
        'index'
    ])->name('activity-logs');

    Route::get('/activity-logs/export', [
        ActivityLogController::class,
        'export'
    ])->name('activity-logs.export');


    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */

    Route::get('/settings', [
        SettingsController::class,
        'index'
    ])->name('settings');

    Route::patch('/settings', [
        SettingsController::class,
        'update'
    ])->name('settings.update');


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| Password Verification
|--------------------------------------------------------------------------
*/

Route::post('/password/{shortCode}', [
    RedirectController::class,
    'verifyPassword'
])->name('short.password.verify');


/*
|--------------------------------------------------------------------------
| Short URL Redirect
|--------------------------------------------------------------------------
|
| IMPORTANT:
| This wildcard route MUST remain at the very bottom.
|
*/

Route::get('/{shortCode}', [
    RedirectController::class,
    'redirect'
])->name('short.redirect');