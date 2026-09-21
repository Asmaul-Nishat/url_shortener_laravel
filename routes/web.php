<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminLinkController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\AdminUserController;
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
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');


/*
|--------------------------------------------------------------------------
| Guest Link / QR Routes
|--------------------------------------------------------------------------
*/

Route::get('/links/create', [
    ShortUrlController::class,
    'create',
])->name('links.create');

Route::post('/links', [
    ShortUrlController::class,
    'store',
])->name('links.store');

Route::post('/qr-codes/guest/generate', [
    QrCodeController::class,
    'generateGuest',
])->name('qr-codes.guest.generate');

Route::get('/qr-codes/guest/download', [
    QrCodeController::class,
    'downloadGuest',
])->name('qr-codes.guest.download');


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Admin Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [
            AdminDashboardController::class,
            'index',
        ])->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Admin Users
        |--------------------------------------------------------------------------
        */

        Route::get('/users', [
            AdminUserController::class,
            'index',
        ])->name('users.index');

        Route::get('/users/{user}', [
            AdminUserController::class,
            'show',
        ])->name('users.show');

        Route::get('/users/{user}/edit', [
            AdminUserController::class,
            'edit',
        ])->name('users.edit');

        Route::patch('/users/{user}', [
            AdminUserController::class,
            'update',
        ])->name('users.update');

        Route::patch('/users/{user}/toggle-status', [
            AdminUserController::class,
            'toggleStatus',
        ])->name('users.toggle-status');

        Route::delete('/users/{user}', [
            AdminUserController::class,
            'destroy',
        ])->name('users.destroy');


        /*
        |--------------------------------------------------------------------------
        | Admin Links
        |--------------------------------------------------------------------------
        */

        Route::get('/links', [
            AdminLinkController::class,
            'index',
        ])->name('links.index');

        Route::get('/links/create', [
            AdminLinkController::class,
            'create',
        ])->name('links.create');

        Route::post('/links', [
            AdminLinkController::class,
            'store',
        ])->name('links.store');

        Route::patch('/links/{id}/favorite', [
            AdminLinkController::class,
            'toggleFavorite',
        ])->name('links.favorite');

        Route::patch('/links/trash/{id}/restore', [
            AdminLinkController::class,
            'restore',
        ])->name('links.restore');

        Route::delete('/links/trash/{id}/force-delete', [
            AdminLinkController::class,
            'forceDelete',
        ])->name('links.force-delete');

        Route::get('/links/{id}', [
            AdminLinkController::class,
            'show',
        ])->name('links.show');

        Route::get('/links/{id}/edit', [
            AdminLinkController::class,
            'edit',
        ])->name('links.edit');

        Route::patch('/links/{id}', [
            AdminLinkController::class,
            'update',
        ])->name('links.update');

        Route::delete('/links/{id}', [
            AdminLinkController::class,
            'destroy',
        ])->name('links.destroy');


        /*
        |--------------------------------------------------------------------------
        | Admin Analytics
        |--------------------------------------------------------------------------
        */

        Route::get('/analytics', [
            AnalyticsController::class,
            'index',
        ])->name('analytics');


        /*
        |--------------------------------------------------------------------------
        | Admin QR Codes
        |--------------------------------------------------------------------------
        */

        Route::get('/qr-codes', [
            QrCodeController::class,
            'adminIndex',
        ])->name('qr-codes.index');

        Route::get('/qr-codes/create', [
            QrCodeController::class,
            'adminCreate',
        ])->name('qr-codes.create');

        Route::post('/qr-codes/generate', [
            QrCodeController::class,
            'adminGenerate',
        ])->name('qr-codes.generate');

        Route::get('/qr-codes/{qrCode}/download/png', [
            QrCodeController::class,
            'adminDownloadPng',
        ])->name('qr-codes.download.png');

        Route::get('/qr-codes/{qrCode}/download/svg', [
            QrCodeController::class,
            'adminDownloadSvg',
        ])->name('qr-codes.download.svg');

        Route::delete('/qr-codes/{qrCode}', [
            QrCodeController::class,
            'adminDestroy',
        ])->name('qr-codes.destroy');


        /*
        |--------------------------------------------------------------------------
        | Admin Reports
        |--------------------------------------------------------------------------
        */

        Route::get('/reports', [
            AdminReportController::class,
            'index',
        ])->name('reports');

        Route::post('/reports/generate', [
            AdminReportController::class,
            'generate',
        ])->name('reports.generate');

        Route::get('/reports/download-filtered', [
            AdminReportController::class,
            'downloadFiltered',
        ])->name('reports.download-filtered');

        Route::get('/reports/all', [
            AdminReportController::class,
            'all',
        ])->name('reports.all');

        Route::get('/reports/{report}/download', [
            AdminReportController::class,
            'download',
        ])->name('reports.download');

        Route::delete('/reports/{report}', [
            AdminReportController::class,
            'destroy',
        ])->name('reports.destroy');


        /*
        |--------------------------------------------------------------------------
        | Admin Activity Logs
        |--------------------------------------------------------------------------
        */

        Route::get('/activity-logs', [
            ActivityLogController::class,
            'index',
        ])->name('activity-logs');

        Route::get('/activity-logs/export', [
            ActivityLogController::class,
            'export',
        ])->name('activity-logs.export');


        /*
        |--------------------------------------------------------------------------
        | Admin Settings
        |--------------------------------------------------------------------------
        */

        Route::get('/settings', [
            AdminSettingsController::class,
            'index',
        ])->name('settings');

        Route::patch('/settings', [
            AdminSettingsController::class,
            'update',
        ])->name('settings.update');

    });


/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'verified',
    'user',
])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | User Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [
        DashboardController::class,
        'index',
    ])->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | User Links
    |--------------------------------------------------------------------------
    */

    Route::get('/links', [
        ShortUrlController::class,
        'index',
    ])->name('links.index');

    Route::get('/links/favorites', [
        ShortUrlController::class,
        'favorites',
    ])->name('links.favorites');

    Route::post('/links/{shortUrl}/favorite', [
        ShortUrlController::class,
        'toggleFavorite',
    ])->name('links.favorite');

    Route::get('/links/trash', [
        ShortUrlController::class,
        'trash',
    ])->name('links.trash');

    Route::delete('/links/{shortUrl}', [
        ShortUrlController::class,
        'destroy',
    ])->name('links.destroy');

    Route::patch('/links/trash/{shortUrl}/restore', [
        ShortUrlController::class,
        'restore',
    ])->name('links.restore');

    Route::delete('/links/trash/{shortUrl}/force-delete', [
        ShortUrlController::class,
        'forceDelete',
    ])->name('links.force-delete');

    Route::delete('/links/trash/empty', [
        ShortUrlController::class,
        'emptyTrash',
    ])->name('links.empty-trash');


    /*
    |--------------------------------------------------------------------------
    | User Analytics
    |--------------------------------------------------------------------------
    */

    Route::get('/analytics', [
        AnalyticsController::class,
        'index',
    ])->name('analytics');


    /*
    |--------------------------------------------------------------------------
    | User QR Codes
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    |
    | /qr-codes        = All QR Codes
    | /qr-codes/create = Create QR
    |
    */


    /*
    |--------------------------------------------------------------------------
    | All QR Codes
    |--------------------------------------------------------------------------
    |
    | URL:
    | /qr-codes
    |
    | Controller:
    | QrCodeController@all
    |
    | View:
    | pages/qr-codes/all.blade.php
    |
    */

    Route::get('/qr-codes', [
        QrCodeController::class,
        'all',
    ])->name('qr-codes');


    /*
    |--------------------------------------------------------------------------
    | Create QR
    |--------------------------------------------------------------------------
    |
    | URL:
    | /qr-codes/create
    |
    | Controller:
    | QrCodeController@index
    |
    | View:
    | pages/qr-codes/index.blade.php
    |
    */

    Route::get('/qr-codes/create', [
        QrCodeController::class,
        'index',
    ])->name('qr-codes.create');


    /*
    |--------------------------------------------------------------------------
    | Generate QR
    |--------------------------------------------------------------------------
    */

    Route::post('/qr-codes/generate', [
        QrCodeController::class,
        'generate',
    ])->name('qr-codes.generate');


    /*
    |--------------------------------------------------------------------------
    | Download PNG
    |--------------------------------------------------------------------------
    */

    Route::get('/qr-codes/{qrCode}/download/png', [
        QrCodeController::class,
        'downloadPng',
    ])->name('qr-codes.download.png');


    /*
    |--------------------------------------------------------------------------
    | Download SVG
    |--------------------------------------------------------------------------
    */

    Route::get('/qr-codes/{qrCode}/download/svg', [
        QrCodeController::class,
        'downloadSvg',
    ])->name('qr-codes.download.svg');


    /*
    |--------------------------------------------------------------------------
    | Delete QR Code
    |--------------------------------------------------------------------------
    */

    Route::delete('/qr-codes/{qrCode}', [
        QrCodeController::class,
        'destroy',
    ])->name('qr-codes.destroy');


    /*
    |--------------------------------------------------------------------------
    | User Reports
    |--------------------------------------------------------------------------
    */

    Route::get('/reports', [
        ReportController::class,
        'index',
    ])->name('reports');

    Route::post('/reports/generate', [
        ReportController::class,
        'generate',
    ])->name('reports.generate');

    Route::get('/reports/{report}/download', [
        ReportController::class,
        'download',
    ])->name('reports.download');

    Route::delete('/reports/{report}', [
        ReportController::class,
        'destroy',
    ])->name('reports.destroy');


    /*
    |--------------------------------------------------------------------------
    | User Activity Logs
    |--------------------------------------------------------------------------
    */

    Route::get('/activity-logs', [
        ActivityLogController::class,
        'index',
    ])->name('activity-logs');

    Route::get('/activity-logs/export', [
        ActivityLogController::class,
        'export',
    ])->name('activity-logs.export');


    /*
    |--------------------------------------------------------------------------
    | User Settings
    |--------------------------------------------------------------------------
    */

    Route::get('/settings', [
        SettingsController::class,
        'index',
    ])->name('settings');

    Route::patch('/settings', [
        SettingsController::class,
        'update',
    ])->name('settings.update');

});


/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'verified',
])->group(function () {

    Route::get('/profile', [
        ProfileController::class,
        'edit',
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update',
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy',
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
| Password Protected Short URLs
|--------------------------------------------------------------------------
*/

Route::post('/password/{shortCode}', [
    RedirectController::class,
    'verifyPassword',
])->name('short.password.verify');


/*
|--------------------------------------------------------------------------
| Short URL Redirect
|--------------------------------------------------------------------------
|
| IMPORTANT:
| This must remain at the very bottom.
|
*/

Route::get('/{shortCode}', [
    RedirectController::class,
    'redirect',
])->name('short.redirect');
