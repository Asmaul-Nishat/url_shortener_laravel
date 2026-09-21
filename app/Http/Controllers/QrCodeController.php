<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use App\Models\ShortUrl;
use App\Models\SystemSetting;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\QrCode as EndroidQrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Logo\Logo;

class QrCodeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | USER QR CODES - CREATE QR PAGE
    |--------------------------------------------------------------------------
    |
    | URL:
    | /qr-codes/create
    |
    | View:
    | resources/views/pages/qr-codes/index.blade.php
    |
    */

    public function index()
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
    | USER QR CODES - ALL QR CODES PAGE
    |--------------------------------------------------------------------------
    |
    | URL:
    | /qr-codes
    |
    | View:
    | resources/views/pages/qr-codes/all.blade.php
    |
    */

    public function all()
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
    | GENERATE AUTHENTICATED USER QR CODE
    |--------------------------------------------------------------------------
    */

    public function generate(
        Request $request
    ) {

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


        if (
            $request->hasFile('logo')
        ) {

            $logoPath = $request
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

        $qrCode = QrCode::create([
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
        | Redirect back to Create QR page
        |--------------------------------------------------------------------------
        |
        | The generated QR is displayed on:
        |
        | /qr-codes/create?qr=ID
        |
        */

        return redirect()
            ->route(
                'qr-codes.create',
                [
                    'qr' =>
                        $qrCode->id,
                ]
            )
            ->with(
                'success',
                'QR code generated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | GUEST QR CODE
    |--------------------------------------------------------------------------
    */

    public function generateGuest(
        Request $request
    ) {

        $settings =
            SystemSetting::current();


        if (
            !$settings->allow_guest_qr_codes
        ) {

            return redirect()
                ->route(
                    'links.create'
                )
                ->with(
                    'error',
                    'Guest QR code generation is disabled.'
                );

        }


        $validated = $request->validate([
            'original_url' => [
                'required',
                'url',
                'max:2048',
            ],

            'size' => [
                'nullable',
                'integer',
                'min:150',
                'max:800',
            ],

            'foreground_color' => [
                'nullable',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],

            'background_color' => [
                'nullable',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],
        ]);


        session([
            'guest_qr' => [

                'original_url' =>
                    $validated['original_url'],

                'size' =>
                    $validated['size']
                    ?? 300,

                'foreground_color' =>
                    $validated['foreground_color']
                    ?? '#111827',

                'background_color' =>
                    $validated['background_color']
                    ?? '#ffffff',
            ],
        ]);


        return redirect()
            ->route(
                'qr-codes.guest.download'
            );
    }


    public function downloadGuest()
    {
        $settings =
            SystemSetting::current();


        abort_unless(
            $settings->allow_guest_qr_codes,
            403
        );


        $guestQr =
            session('guest_qr');


        abort_unless(
            $guestQr,
            404
        );


        $qrCode =
            new EndroidQrCode(
                data:
                    $guestQr['original_url'],

                encoding:
                    new Encoding('UTF-8'),

                errorCorrectionLevel:
                    ErrorCorrectionLevel::High,

                size:
                    $guestQr['size'],

                margin:
                    10,

                roundBlockSizeMode:
                    RoundBlockSizeMode::Margin,

                foregroundColor:
                    $this->hexToColor(
                        $guestQr['foreground_color']
                    ),

                backgroundColor:
                    $this->hexToColor(
                        $guestQr['background_color']
                    )
            );


        $writer =
            new PngWriter();


        $result =
            $writer->write(
                $qrCode
            );


        session()->forget(
            'guest_qr'
        );


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
    | ADMIN QR CODES
    |--------------------------------------------------------------------------
    */

    public function adminIndex()
    {
        $qrCodes = QrCode::with([
            'shortUrl',
            'shortUrl.user',
        ])
            ->latest()
            ->paginate(10);


        return view(
            'pages.admin.qr-codes.index',
            [
                'qrCodes' =>
                    $qrCodes,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN CREATE QR
    |--------------------------------------------------------------------------
    */

    public function adminCreate()
    {
        $shortUrls =
            ShortUrl::with('user')
                ->latest()
                ->get();


        $generatedQr =
            null;


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
            [
                'shortUrls' =>
                    $shortUrls,

                'generatedQr' =>
                    $generatedQr,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN GENERATE QR
    |--------------------------------------------------------------------------
    */

    public function adminGenerate(
        Request $request
    ) {

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
        ]);


        $shortUrl =
            ShortUrl::findOrFail(
                $validated['short_url_id']
            );


        $logoPath =
            null;


        if (
            $request->hasFile('logo')
        ) {

            $logoPath =
                $request
                    ->file('logo')
                    ->store(
                        'qr-logos',
                        'public'
                    );

        }


        $qrCode =
            QrCode::create([
                'user_id' =>
                    $shortUrl->user_id,

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
    | ADMIN DOWNLOAD PNG
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


        $qr =
            $this->buildQrCode(
                $qrCode,
                $shortUrl->short_url
            );


        $writer =
            new PngWriter();


        $logo =
            null;


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
                $qr,
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
    | ADMIN DOWNLOAD SVG
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


        $qr =
            $this->buildQrCode(
                $qrCode,
                $shortUrl->short_url
            );


        $writer =
            new SvgWriter();


        $result =
            $writer->write(
                $qr
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
    | ADMIN DELETE QR CODE
    |--------------------------------------------------------------------------
    */

    public function adminDestroy(
        QrCode $qrCode
    ) {

        $this->authorizeAdminQrCode(
            $qrCode
        );


        $this->deleteQrCode(
            $qrCode
        );


        if (
            (int) session(
                'admin_generated_qr_id'
            ) ===
            (int) $qrCode->id
        ) {

            session()->forget(
                'admin_generated_qr_id'
            );

        }


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
    | USER DOWNLOAD PNG
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


        $qr =
            $this->buildQrCode(
                $qrCode,
                $shortUrl->short_url
            );


        $writer =
            new PngWriter();


        $logo =
            null;


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
                $qr,
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
    | USER DOWNLOAD SVG
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


        $qr =
            $this->buildQrCode(
                $qrCode,
                $shortUrl->short_url
            );


        $writer =
            new SvgWriter();


        $result =
            $writer->write(
                $qr
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
    | USER DELETE QR CODE
    |--------------------------------------------------------------------------
    */

    public function destroy(
        QrCode $qrCode
    ) {

        $this->authorizeQrCode(
            $qrCode
        );


        $this->deleteQrCode(
            $qrCode
        );


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
    | QR BUILDER
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
    | HEX COLOR
    |--------------------------------------------------------------------------
    */

    private function hexToColor(
        string $hex
    ): Color {

        $hex =
            ltrim(
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
    | USER AUTHORIZATION
    |--------------------------------------------------------------------------
    */

    private function authorizeQrCode(
        QrCode $qrCode
    ): void {

        abort_unless(
            Auth::check() &&
            $qrCode->user_id ===
                Auth::id(),
            403
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN AUTHORIZATION
    |--------------------------------------------------------------------------
    */

    private function authorizeAdminQrCode(
        QrCode $qrCode
    ): void {

        abort_unless(
            Auth::check() &&
            Auth::user()->role ===
                'admin',
            403
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE QR CODE
    |--------------------------------------------------------------------------
    */

    private function deleteQrCode(
        QrCode $qrCode
    ): void {

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


        $qrCode->delete();
    }
}
