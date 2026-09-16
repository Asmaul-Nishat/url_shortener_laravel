<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminLinkController;
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
|
| Guests can create temporary short URLs.
| Authenticated users can also use this endpoint.
|
*/

Route::get('/links/create', [
    ShortUrlController::class,
    'create',
])->name('links.create');

Route::post('/links', [
    ShortUrlController::class,
    'store',
])->name('links.store');


/*
|--------------------------------------------------------------------------
| Public Guest QR Code
|--------------------------------------------------------------------------
|
| Guests can generate a QR code without logging in.
|
*/

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
| Admin Panel
|--------------------------------------------------------------------------
|
| Only authenticated, verified administrators can access
| these routes.
|
*/

Route::middleware([
    'auth',
    'verified',
    'admin',
])
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
        |
        | Admin can manage ALL users' links.
        |
        | Admin Links:
        | - All Links
        | - Create Link
        | - Favorites
        | - Trash
        |
        */


        /*
        |--------------------------------------------------------------------------
        | All Links
        |--------------------------------------------------------------------------
        |
        | /admin/links
        |
        | Also handles:
        |
        | /admin/links?favorite=1
        | /admin/links?trash=1
        |
        */

        Route::get('/links', [
            AdminLinkController::class,
            'index',
        ])->name('links.index');


        /*
        |--------------------------------------------------------------------------
        | Create Link
        |--------------------------------------------------------------------------
        |
        | MUST be before /links/{id}.
        |
        */

        Route::get('/links/create', [
            AdminLinkController::class,
            'create',
        ])->name('links.create');


        /*
        |--------------------------------------------------------------------------
        | Store Link
        |--------------------------------------------------------------------------
        */

        Route::post('/links', [
            AdminLinkController::class,
            'store',
        ])->name('links.store');


        /*
        |--------------------------------------------------------------------------
        | Admin Trash Actions
        |--------------------------------------------------------------------------
        |
        | These MUST appear before /links/{id}.
        |
        */


        /*
        | Restore trashed link
        |
        | /admin/links/trash/{id}/restore
        |
        */

        Route::patch('/links/trash/{id}/restore', [
            AdminLinkController::class,
            'restore',
        ])->name('links.restore');


        /*
        | Permanently delete trashed link
        |
        | /admin/links/trash/{id}/force-delete
        |
        */

        Route::delete('/links/trash/{id}/force-delete', [
            AdminLinkController::class,
            'forceDelete',
        ])->name('links.force-delete');


        /*
        |--------------------------------------------------------------------------
        | View Individual Link
        |--------------------------------------------------------------------------
        |
        | Using {id} instead of implicit {shortUrl} binding is intentional.
        |
        | The controller uses withTrashed(), so Admin can also
        | view links that are currently in Trash.
        |
        */

        Route::get('/links/{id}', [
            AdminLinkController::class,
            'show',
        ])->name('links.show');


        /*
        |--------------------------------------------------------------------------
        | Edit Individual Link
        |--------------------------------------------------------------------------
        |
        | Admin can edit any user's link.
        |
        */

        Route::get('/links/{id}/edit', [
            AdminLinkController::class,
            'edit',
        ])->name('links.edit');


        /*
        |--------------------------------------------------------------------------
        | Update Individual Link
        |--------------------------------------------------------------------------
        */

        Route::patch('/links/{id}', [
            AdminLinkController::class,
            'update',
        ])->name('links.update');


        /*
        |--------------------------------------------------------------------------
        | Move Link To Trash
        |--------------------------------------------------------------------------
        */

        Route::delete('/links/{id}', [
            AdminLinkController::class,
            'destroy',
        ])->name('links.destroy');


        /*
        |--------------------------------------------------------------------------
        | Admin Analytics
        |--------------------------------------------------------------------------
        |
        | Admin sees system-wide analytics.
        |
        */

        Route::get('/analytics', [
            AnalyticsController::class,
            'index',
        ])->name('analytics');


        /*
        |--------------------------------------------------------------------------
        | Admin Activity Logs
        |--------------------------------------------------------------------------
        |
        | Admin sees system-wide activity logs.
        |
        */

        Route::get('/activity-logs', [
            ActivityLogController::class,
            'index',
        ])->name('activity-logs');

        Route::get('/activity-logs/export', [
            ActivityLogController::class,
            'export',
        ])->name('activity-logs.export');
    });


/*
|--------------------------------------------------------------------------
| Authenticated User Panel
|--------------------------------------------------------------------------
|
| Only normal users with role = "user" can access these routes.
|
| Administrators are intentionally prevented from accessing the
| normal user business panel.
|
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


    /*
    | All user's links
    */

    Route::get('/links', [
        ShortUrlController::class,
        'index',
    ])->name('links.index');


    /*
    | User Favorites
    */

    Route::get('/links/favorites', [
        ShortUrlController::class,
        'favorites',
    ])->name('links.favorites');


    /*
    | Add/remove favorite
    */

    Route::post('/links/{shortUrl}/favorite', [
        ShortUrlController::class,
        'toggleFavorite',
    ])->name('links.favorite');


    /*
    | User Trash
    */

    Route::get('/links/trash', [
        ShortUrlController::class,
        'trash',
    ])->name('links.trash');


    /*
    | Move user's link to Trash
    */

    Route::delete('/links/{shortUrl}', [
        ShortUrlController::class,
        'destroy',
    ])->name('links.destroy');


    /*
    | Restore user's trashed link
    */

    Route::patch('/links/trash/{shortUrl}/restore', [
        ShortUrlController::class,
        'restore',
    ])->name('links.restore');


    /*
    | Permanently delete user's trashed link
    */

    Route::delete('/links/trash/{shortUrl}/force-delete', [
        ShortUrlController::class,
        'forceDelete',
    ])->name('links.force-delete');


    /*
    | Empty user's entire Trash
    */

    Route::delete('/links/trash/empty', [
        ShortUrlController::class,
        'emptyTrash',
    ])->name('links.empty-trash');


    /*
    |--------------------------------------------------------------------------
    | User Analytics
    |--------------------------------------------------------------------------
    |
    | Only the logged-in user's analytics should be shown
    | by AnalyticsController.
    |
    */

    Route::get('/analytics', [
        AnalyticsController::class,
        'index',
    ])->name('analytics');


    /*
    |--------------------------------------------------------------------------
    | User QR Codes
    |--------------------------------------------------------------------------
    */


    /*
    | QR Code list
    */

    Route::get('/qr-codes', [
        QrCodeController::class,
        'index',
    ])->name('qr-codes');


    /*
    | Generate QR Code
    */

    Route::post('/qr-codes/generate', [
        QrCodeController::class,
        'generate',
    ])->name('qr-codes.generate');


    /*
    | Download PNG
    */

    Route::get('/qr-codes/{qrCode}/download/png', [
        QrCodeController::class,
        'downloadPng',
    ])->name('qr-codes.download.png');


    /*
    | Download SVG
    */

    Route::get('/qr-codes/{qrCode}/download/svg', [
        QrCodeController::class,
        'downloadSvg',
    ])->name('qr-codes.download.svg');


    /*
    | Delete QR Code
    */

    Route::delete('/qr-codes/{qrCode}', [
        QrCodeController::class,
        'destroy',
    ])->name('qr-codes.destroy');


    /*
    |--------------------------------------------------------------------------
    | User Reports
    |--------------------------------------------------------------------------
    |
    | Only the logged-in user's reports should be returned
    | by ReportController.
    |
    */

    Route::get('/reports', [
        ReportController::class,
        'index',
    ])->name('reports');


    /*
    | Generate Report
    */

    Route::post('/reports/generate', [
        ReportController::class,
        'generate',
    ])->name('reports.generate');


    /*
    | Download Report
    */

    Route::get('/reports/{report}/download', [
        ReportController::class,
        'download',
    ])->name('reports.download');


    /*
    | Delete Report
    */

    Route::delete('/reports/{report}', [
        ReportController::class,
        'destroy',
    ])->name('reports.destroy');


    /*
    |--------------------------------------------------------------------------
    | User Activity Logs
    |--------------------------------------------------------------------------
    |
    | Only the logged-in user's activity should be returned
    | by ActivityLogController.
    |
    */

    Route::get('/activity-logs', [
        ActivityLogController::class,
        'index',
    ])->name('activity-logs');


    /*
    | Export user's activity logs
    */

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


    /*
    | Update user settings
    */

    Route::patch('/settings', [
        SettingsController::class,
        'update',
    ])->name('settings.update');
});


/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
|
| Account-level profile.
|
| Both Admin and User can manage their own profile.
|
*/

Route::middleware([
    'auth',
    'verified',
])->group(function () {

    /*
    | Edit profile
    */

    Route::get('/profile', [
        ProfileController::class,
        'edit',
    ])->name('profile.edit');


    /*
    | Update profile
    */

    Route::patch('/profile', [
        ProfileController::class,
        'update',
    ])->name('profile.update');


    /*
    | Delete own account
    */

    Route::delete('/profile', [
        ProfileController::class,
        'destroy',
    ])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| Password-Protected Short URL
|--------------------------------------------------------------------------
|
| This route handles password verification for protected links.
|
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
|
| This wildcard route MUST remain at the very bottom of this file.
|
| Example:
|
| /abc123
| /my-custom-link
|
*/

Route::get('/{shortCode}', [
    RedirectController::class,
    'redirect',
])->name('short.redirect');
