<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\UserSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();

        $settings = UserSetting::firstOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'language' => 'English',
                'timezone' => 'Asia/Dhaka',
                'date_format' => 'MMM DD, YYYY',
                'default_expiration' => 'Never',
                'allow_custom_aliases' => true,
                'duplicate_detection' => false,
                'link_expiration_alerts' => true,
                'report_notifications' => false,
                'security_alerts' => true,
            ]
        );

        $tab = $request->input('tab', 'general');

        $allowedTabs = [
            'general',
            'profile',
            'security',
            'notifications',
            'api',
        ];

        if (!in_array($tab, $allowedTabs, true)) {
            $tab = 'general';
        }

        return view(
            'pages.settings.index',
            compact(
                'settings',
                'tab'
            )
        );
    }

    /**
     * Update application settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'language' => [
                'required',
                'in:English,Bangla',
            ],

            'timezone' => [
                'required',
                'string',
                'max:100',
            ],

            'date_format' => [
                'required',
                'in:MMM DD, YYYY,DD/MM/YYYY,MM/DD/YYYY,YYYY-MM-DD',
            ],

            'default_expiration' => [
                'required',
                'in:Never,7 Days,30 Days,90 Days,1 Year',
            ],

            'allow_custom_aliases' => [
                'nullable',
                'boolean',
            ],

            'duplicate_detection' => [
                'nullable',
                'boolean',
            ],

            'link_expiration_alerts' => [
                'nullable',
                'boolean',
            ],

            'report_notifications' => [
                'nullable',
                'boolean',
            ],

            'security_alerts' => [
                'nullable',
                'boolean',
            ],
        ]);

        UserSetting::updateOrCreate(
            [
                'user_id' => Auth::id(),
            ],
            [
                'language' => $validated['language'],
                'timezone' => $validated['timezone'],
                'date_format' => $validated['date_format'],
                'default_expiration' => $validated['default_expiration'],

                'allow_custom_aliases' =>
                    $request->boolean('allow_custom_aliases'),

                'duplicate_detection' =>
                    $request->boolean('duplicate_detection'),

                'link_expiration_alerts' =>
                    $request->boolean('link_expiration_alerts'),

                'report_notifications' =>
                    $request->boolean('report_notifications'),

                'security_alerts' =>
                    $request->boolean('security_alerts'),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Apply the newly selected language immediately
        |--------------------------------------------------------------------------
        */

        App::setLocale(
            $validated['language'] === 'Bangla'
                ? 'bn'
                : 'en'
        );

        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        ActivityLogger::log(
            'Settings Updated',
            'Settings',
            'Updated application, URL, and notification preferences.'
        );

        return redirect()
            ->route('settings')
            ->with(
                'success',
                __('messages.settings_saved')
            );
    }
}
