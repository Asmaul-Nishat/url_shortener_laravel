<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSettingsController extends Controller
{
    /**
     * Display the admin system settings page.
     */
    public function index(): View
    {
        $settings = SystemSetting::current();

        return view(
            'pages.admin.settings.index',
            compact('settings')
        );
    }

    /**
     * Update admin system settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'default_link_status' => [
                'required',
                'in:active,disabled',
            ],

            'default_expiration_days' => [
                'required',
                'integer',
                'min:0',
                'max:3650',
            ],

            'allow_guest_short_urls' => [
                'nullable',
                'boolean',
            ],

            'allow_guest_qr_codes' => [
                'nullable',
                'boolean',
            ],

            'enable_analytics' => [
                'nullable',
                'boolean',
            ],

            'enable_reports' => [
                'nullable',
                'boolean',
            ],

            'enable_activity_logs' => [
                'nullable',
                'boolean',
            ],
        ]);

        $settings = SystemSetting::current();

        $settings->update([
            'default_link_status' =>
                $validated['default_link_status'],

            'default_expiration_days' =>
                $validated['default_expiration_days'],

            'allow_guest_short_urls' =>
                $request->boolean('allow_guest_short_urls'),

            'allow_guest_qr_codes' =>
                $request->boolean('allow_guest_qr_codes'),

            'enable_analytics' =>
                $request->boolean('enable_analytics'),

            'enable_reports' =>
                $request->boolean('enable_reports'),

            'enable_activity_logs' =>
                $request->boolean('enable_activity_logs'),
        ]);

        return redirect()
            ->route('admin.settings')
            ->with(
                'success',
                'System settings updated successfully.'
            );
    }
}