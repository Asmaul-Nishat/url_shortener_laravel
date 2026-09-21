<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\QrCode;
use App\Models\ShortUrl;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\QrCode as EndroidQrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class QrCodeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | User - Create QR Code Page
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $qrCodes = QrCode::with('shortUrl')
            ->where(
                'user_id',
                Auth::id()
            )
            ->latest()
            ->paginate(10);

        $shortUrls = ShortUrl::where(
            'user_id',
            Auth::id()
        )
            ->latest()
            ->get();

        return view(
            'pages.qr-codes.index',
            compact(
                'qrCodes',
                'shortUrls'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | User - All QR Codes
    |--------------------------------------------------------------------------
    */

    public function all(): View
    {
        $qrCodes = QrCode::with('shortUrl')
            ->where(
                'user_id',
                Auth::id()
            )
            ->latest()
            ->paginate(10);

        return view(
            'pages.qr-codes.all',
            compact(
                'qrCodes'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | User - Generate Authenticated QR Code
    |--------------------------------------------------------------------------
    */

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'short_url_id' => [
                'required',
                'integer',
                'exists:short_urls,id',
            ],

            'size' => [
                'required',
                'integer',
                'min:150',
                'max:800',
            ],

            'foreground_color' => [
                'required',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],

            'background_color' => [
                'required',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],

            'logo' => [
                'nullable',
                'image',
                'mimes:png,jpg,jpeg',
                'max:2048',
            ],
        ], [
            'short_url_id.required' =>
                'Please select a short URL.',

            'short_url_id.exists' =>
                'The selected short URL does not exist.',

            'size.min' =>
                'QR code size must be at least 150 pixels.',

            'size.max' =>
                'QR code size cannot exceed 800 pixels.',

            'foreground_color.regex' =>
                'Please select a valid foreground color.',

            'background_color.regex' =>
                'Please select a valid background color.',

            'logo.image' =>
                'The logo must be an image.',

            'logo.max' =>
                'The logo cannot be larger than 2 MB.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Make sure selected Short URL belongs to current user
        |--------------------------------------------------------------------------
        */

        $shortUrl = ShortUrl::where(
            'id',
            $validated['short_url_id']
        )
            ->where(
                'user_id',
                Auth::id()
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Store Logo
        |--------------------------------------------------------------------------
        */

        $logoPath = null;

        if ($request->hasFile('logo')) {

            $logoPath = $request
                ->file('logo')
                ->store(
                    'qr-logos',
                    'public'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Create QR Code Database Record
        |--------------------------------------------------------------------------
        */

        $qrCodeRecord = QrCode::create([
            'user_id' =>
                Auth::id(),

            'short_url_id' =>
                $shortUrl->id,

            'size' =>
                $validated['size'],

            'foreground_color' =>
                $validated['foreground_color'],

            'background_color' =>
                $validated['background_color'],

            'logo_path' =>
                $logoPath,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Create Activity Log
        |--------------------------------------------------------------------------
        */

        ActivityLog::create([
            'user_id' =>
                Auth::id(),

            'activity' =>
                'Created QR Code',

            'type' =>
                'QR Code',

            'description' =>
                'Created a QR code for short URL: ' .
                $shortUrl->short_url,

            'ip_address' =>
                $request->ip(),

            'status' =>
                'Successful',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect To Create QR Page
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'qr-codes.create',
                [
                    'qr' =>
                        $qrCodeRecord->id,
                ]
            )
            ->with(
                'success',
                'QR code generated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Guest - Generate QR Code
    |--------------------------------------------------------------------------
    */

    public function generateGuest(
        Request $request
    ) {
        $validated = $request->validate([
            'original_url' => [
                'required',
                'url',
                'max:2048',
            ],
        ], [
            'original_url.required' =>
                'Please enter a URL.',

            'original_url.url' =>
                'Please enter a valid URL.',

            'original_url.max' =>
                'The URL cannot be longer than 2048 characters.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Store Guest QR Data In Session
        |--------------------------------------------------------------------------
        */

        $request->session()->put(
            'guest_qr_data',
            [
                'data' =>
                    $validated['original_url'],

                'size' =>
                    400,

                'foreground_color' =>
                    '#111827',

                'background_color' =>
                    '#FFFFFF',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Redirect To Home
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('home')
            ->with(
                'guest_qr',
                true
            )
            ->with(
                'success',
                'QR code generated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Guest - Download QR Code
    |--------------------------------------------------------------------------
    */

    public function downloadGuest()
    {
        $guestQr = session(
            'guest_qr_data'
        );


        if (
            !is_array($guestQr) ||
            empty($guestQr['data'])
        ) {
            abort(
                404,
                'Guest QR code not found.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Build Guest QR Code
        |--------------------------------------------------------------------------
        */

        $qrCode = new EndroidQrCode(
            data:
                $guestQr['data'],

            encoding:
                new Encoding('UTF-8'),

            errorCorrectionLevel:
                ErrorCorrectionLevel::High,

            size:
                (int) (
                    $guestQr['size'] ?? 400
                ),

            margin:
                10,

            roundBlockSizeMode:
                RoundBlockSizeMode::Margin,

            foregroundColor:
                $this->hexToColor(
                    $guestQr['foreground_color']
                    ?? '#111827'
                ),

            backgroundColor:
                $this->hexToColor(
                    $guestQr['background_color']
                    ?? '#FFFFFF'
                )
        );


        /*
        |--------------------------------------------------------------------------
        | Write PNG
        |--------------------------------------------------------------------------
        */

        $writer = new PngWriter();

        $result = $writer->write(
            $qrCode
        );


        /*
        |--------------------------------------------------------------------------
        | Remove Temporary Data
        |--------------------------------------------------------------------------
        */

        session()->forget(
            'guest_qr_data'
        );


        /*
        |--------------------------------------------------------------------------
        | Download Response
        |--------------------------------------------------------------------------
        */

        return response(
            $result->getString(),
            200,
            [
                'Content-Type' =>
                    'image/png',

                'Content-Disposition' =>
                    'attachment; filename="guest-qr-code.png"',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | User - Download PNG
    |--------------------------------------------------------------------------
    */

    public function downloadPng(
        QrCode $qrCode
    ) {
        $this->authorizeQrCode(
            $qrCode
        );


        $shortUrl =
            $qrCode->shortUrl;


        abort_unless(
            $shortUrl,
            404
        );


        /*
        |--------------------------------------------------------------------------
        | Build QR Code
        |--------------------------------------------------------------------------
        */

        $builder =
            $this->buildQrCode(
                $qrCode,
                $shortUrl->short_url
            );


        /*
        |--------------------------------------------------------------------------
        | PNG Writer
        |--------------------------------------------------------------------------
        */

        $writer =
            new PngWriter();


        /*
        |--------------------------------------------------------------------------
        | Logo
        |--------------------------------------------------------------------------
        */

        $logo = null;

        if (
            $qrCode->logo_path &&
            Storage::disk('public')->exists(
                $qrCode->logo_path
            )
        ) {

            $logo = new Logo(
                path:
                    Storage::disk('public')->path(
                        $qrCode->logo_path
                    ),

                resizeToWidth:
                    (int) (
                        $qrCode->size * 0.18
                    ),

                punchoutBackground:
                    true
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Generate PNG
        |--------------------------------------------------------------------------
        */

        $result =
            $writer->write(
                $builder,
                $logo
            );


        return response(
            $result->getString(),
            200,
            [
                'Content-Type' =>
                    'image/png',

                'Content-Disposition' =>
                    'attachment; filename="qr-code-' .
                    $qrCode->id .
                    '.png"',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | User - Download SVG
    |--------------------------------------------------------------------------
    */

    public function downloadSvg(
        QrCode $qrCode
    ) {
        $this->authorizeQrCode(
            $qrCode
        );


        $shortUrl =
            $qrCode->shortUrl;


        abort_unless(
            $shortUrl,
            404
        );


        /*
        |--------------------------------------------------------------------------
        | Build QR Code
        |--------------------------------------------------------------------------
        */

        $builder =
            $this->buildQrCode(
                $qrCode,
                $shortUrl->short_url
            );


        /*
        |--------------------------------------------------------------------------
        | SVG Writer
        |--------------------------------------------------------------------------
        */

        $writer =
            new SvgWriter();


        $result =
            $writer->write(
                $builder
            );


        return response(
            $result->getString(),
            200,
            [
                'Content-Type' =>
                    'image/svg+xml',

                'Content-Disposition' =>
                    'attachment; filename="qr-code-' .
                    $qrCode->id .
                    '.svg"',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | User - Delete QR Code
    |--------------------------------------------------------------------------
    */

    public function destroy(
        QrCode $qrCode
    ) {
        $this->authorizeQrCode(
            $qrCode
        );


        /*
        |--------------------------------------------------------------------------
        | Save Information For Activity Log
        |--------------------------------------------------------------------------
        */

        $shortUrl =
            $qrCode->shortUrl;


        /*
        |--------------------------------------------------------------------------
        | Delete Logo
        |--------------------------------------------------------------------------
        */

        if (
            $qrCode->logo_path &&
            Storage::disk('public')->exists(
                $qrCode->logo_path
            )
        ) {

            Storage::disk('public')->delete(
                $qrCode->logo_path
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Delete QR Code
        |--------------------------------------------------------------------------
        */

        $qrCode->delete();


        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        ActivityLog::create([
            'user_id' =>
                Auth::id(),

            'activity' =>
                'Deleted QR Code',

            'type' =>
                'QR Code',

            'description' =>
                'Deleted QR code' .
                (
                    $shortUrl
                        ? ' for short URL: ' .
                          $shortUrl->short_url
                        : '.'
                ),

            'ip_address' =>
                request()->ip(),

            'status' =>
                'Successful',
        ]);


        return redirect()
            ->route(
                'qr-codes'
            )
            ->with(
                'success',
                'QR code deleted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Admin - All QR Codes
    |--------------------------------------------------------------------------
    */

    public function adminIndex(): View
    {
        $qrCodes = QrCode::with([
            'shortUrl',
            'shortUrl.user',
        ])
            ->latest()
            ->paginate(10);


        return view(
            'pages.admin.qr-codes.index',
            compact(
                'qrCodes'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Admin - Create QR Code Page
    |--------------------------------------------------------------------------
    */

    public function adminCreate(): View
    {
        $shortUrls = ShortUrl::with('user')
            ->latest()
            ->get();


        $generatedQr = null;


        if (
            session()->has(
                'admin_generated_qr_id'
            )
        ) {

            $generatedQr =
                QrCode::with([
                    'shortUrl',
                    'shortUrl.user',
                ])
                    ->find(
                        session(
                            'admin_generated_qr_id'
                        )
                    );
        }


        return view(
            'pages.admin.qr-codes.create',
            compact(
                'shortUrls',
                'generatedQr'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Admin - Generate QR Code
    |--------------------------------------------------------------------------
    */

    public function adminGenerate(
        Request $request
    ) {
        $validated = $request->validate([
            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],

            'short_url_id' => [
                'required',
                'integer',
                'exists:short_urls,id',
            ],

            'size' => [
                'required',
                'integer',
                'min:150',
                'max:800',
            ],

            'foreground_color' => [
                'required',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],

            'background_color' => [
                'required',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],

            'logo' => [
                'nullable',
                'image',
                'mimes:png,jpg,jpeg',
                'max:2048',
            ],
        ], [
            'user_id.required' =>
                'Please select a user.',

            'user_id.exists' =>
                'The selected user does not exist.',

            'short_url_id.required' =>
                'Please select a short URL.',

            'short_url_id.exists' =>
                'The selected short URL does not exist.',

            'size.min' =>
                'QR code size must be at least 150 pixels.',

            'size.max' =>
                'QR code size cannot exceed 800 pixels.',

            'foreground_color.regex' =>
                'Please select a valid foreground color.',

            'background_color.regex' =>
                'Please select a valid background color.',

            'logo.image' =>
                'The logo must be an image.',

            'logo.max' =>
                'The logo cannot be larger than 2 MB.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Make Sure Short URL Belongs To Selected User
        |--------------------------------------------------------------------------
        */

        $shortUrl = ShortUrl::where(
            'id',
            $validated['short_url_id']
        )
            ->where(
                'user_id',
                $validated['user_id']
            )
            ->first();


        if (!$shortUrl) {

            return back()
                ->withInput()
                ->withErrors([
                    'short_url_id' =>
                        'The selected short URL does not belong to the selected user.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Store Logo
        |--------------------------------------------------------------------------
        */

        $logoPath = null;

        if ($request->hasFile('logo')) {

            $logoPath =
                $request
                    ->file('logo')
                    ->store(
                        'qr-logos',
                        'public'
                    );
        }


        /*
        |--------------------------------------------------------------------------
        | Create QR Code
        |--------------------------------------------------------------------------
        */

        $qrCode =
            QrCode::create([
                'user_id' =>
                    $validated['user_id'],

                'short_url_id' =>
                    $shortUrl->id,

                'size' =>
                    $validated['size'],

                'foreground_color' =>
                    $validated['foreground_color'],

                'background_color' =>
                    $validated['background_color'],

                'logo_path' =>
                    $logoPath,
            ]);


        /*
        |--------------------------------------------------------------------------
        | Create Admin Activity Log
        |--------------------------------------------------------------------------
        */

        ActivityLog::create([
            'user_id' =>
                Auth::id(),

            'activity' =>
                'Created QR Code',

            'type' =>
                'QR Code',

            'description' =>
                'Created a QR code for user ID ' .
                $validated['user_id'] .
                ' using short URL: ' .
                $shortUrl->short_url,

            'ip_address' =>
                $request->ip(),

            'status' =>
                'Successful',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Keep Generated QR On Create Page
        |--------------------------------------------------------------------------
        */

        session([
            'admin_generated_qr_id' =>
                $qrCode->id,
        ]);


        return redirect()
            ->route(
                'admin.qr-codes.create'
            )
            ->with(
                'success',
                'QR code generated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Admin - Download PNG
    |--------------------------------------------------------------------------
    */

    public function adminDownloadPng(
        QrCode $qrCode
    ) {
        $this->authorizeAdminQrCode(
            $qrCode
        );


        $shortUrl =
            $qrCode->shortUrl;


        abort_unless(
            $shortUrl,
            404
        );


        $builder =
            $this->buildQrCode(
                $qrCode,
                $shortUrl->short_url
            );


        $writer =
            new PngWriter();


        $logo = null;

        if (
            $qrCode->logo_path &&
            Storage::disk('public')->exists(
                $qrCode->logo_path
            )
        ) {

            $logo =
                new Logo(
                    path:
                        Storage::disk('public')->path(
                            $qrCode->logo_path
                        ),

                    resizeToWidth:
                        (int) (
                            $qrCode->size * 0.18
                        ),

                    punchoutBackground:
                        true
                );
        }


        $result =
            $writer->write(
                $builder,
                $logo
            );


        return response(
            $result->getString(),
            200,
            [
                'Content-Type' =>
                    'image/png',

                'Content-Disposition' =>
                    'attachment; filename="qr-code-' .
                    $qrCode->id .
                    '.png"',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Admin - Download SVG
    |--------------------------------------------------------------------------
    */

    public function adminDownloadSvg(
        QrCode $qrCode
    ) {
        $this->authorizeAdminQrCode(
            $qrCode
        );


        $shortUrl =
            $qrCode->shortUrl;


        abort_unless(
            $shortUrl,
            404
        );


        $builder =
            $this->buildQrCode(
                $qrCode,
                $shortUrl->short_url
            );


        $writer =
            new SvgWriter();


        $result =
            $writer->write(
                $builder
            );


        return response(
            $result->getString(),
            200,
            [
                'Content-Type' =>
                    'image/svg+xml',

                'Content-Disposition' =>
                    'attachment; filename="qr-code-' .
                    $qrCode->id .
                    '.svg"',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Admin - Delete QR Code
    |--------------------------------------------------------------------------
    */

    public function adminDestroy(
        QrCode $qrCode
    ) {
        $this->authorizeAdminQrCode(
            $qrCode
        );


        $shortUrl =
            $qrCode->shortUrl;


        /*
        |--------------------------------------------------------------------------
        | Delete Logo
        |--------------------------------------------------------------------------
        */

        if (
            $qrCode->logo_path &&
            Storage::disk('public')->exists(
                $qrCode->logo_path
            )
        ) {

            Storage::disk('public')->delete(
                $qrCode->logo_path
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Delete QR Code
        |--------------------------------------------------------------------------
        */

        $qrCode->delete();


        /*
        |--------------------------------------------------------------------------
        | Remove Generated QR From Session
        |--------------------------------------------------------------------------
        */

        if (
            (string) session(
                'admin_generated_qr_id'
            ) ===
            (string) $qrCode->id
        ) {

            session()->forget(
                'admin_generated_qr_id'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        ActivityLog::create([
            'user_id' =>
                Auth::id(),

            'activity' =>
                'Deleted QR Code',

            'type' =>
                'QR Code',

            'description' =>
                'Deleted QR code ID ' .
                $qrCode->id .
                (
                    $shortUrl
                        ? ' for short URL: ' .
                          $shortUrl->short_url
                        : '.'
                ),

            'ip_address' =>
                request()->ip(),

            'status' =>
                'Successful',
        ]);


        return redirect()
            ->route(
                'admin.qr-codes.index'
            )
            ->with(
                'success',
                'QR code deleted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Build QR Code
    |--------------------------------------------------------------------------
    */

    private function buildQrCode(
        QrCode $qrCode,
        string $data
    ): EndroidQrCode {

        return new EndroidQrCode(
            data:
                $data,

            encoding:
                new Encoding('UTF-8'),

            errorCorrectionLevel:
                ErrorCorrectionLevel::High,

            size:
                $qrCode->size,

            margin:
                10,

            roundBlockSizeMode:
                RoundBlockSizeMode::Margin,

            foregroundColor:
                $this->hexToColor(
                    $qrCode->foreground_color
                ),

            backgroundColor:
                $this->hexToColor(
                    $qrCode->background_color
                )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Convert Hex Color
    |--------------------------------------------------------------------------
    */

    private function hexToColor(
        string $hex
    ): Color {

        $hex = ltrim(
            $hex,
            '#'
        );


        return new Color(
            hexdec(
                substr(
                    $hex,
                    0,
                    2
                )
            ),

            hexdec(
                substr(
                    $hex,
                    2,
                    2
                )
            ),

            hexdec(
                substr(
                    $hex,
                    4,
                    2
                )
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Authorize User QR Code
    |--------------------------------------------------------------------------
    */

    private function authorizeQrCode(
        QrCode $qrCode
    ): void {

        abort_unless(
            (int) $qrCode->user_id ===
                (int) Auth::id(),
            403
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Authorize Admin QR Code
    |--------------------------------------------------------------------------
    */

    private function authorizeAdminQrCode(
        QrCode $qrCode
    ): void {

        abort_unless(
            Auth::check() &&
            Auth::user()->isAdmin(),
            403
        );
    }
}
