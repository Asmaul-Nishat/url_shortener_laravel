<?php

namespace App\Http\Controllers;

use App\Models\AnonymousGeneration;
use App\Models\QrCode;
use App\Models\ShortUrl;
use App\Models\SystemSetting;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\QrCode as EndroidQrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class QrCodeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | QR Code Index
    |--------------------------------------------------------------------------
    */
    public function index(): View
    {
        $shortUrls = ShortUrl::where(
            'user_id',
            Auth::id()
        )
            ->latest()
            ->get();

        $qrCodes = QrCode::with('shortUrl')
            ->where(
                'user_id',
                Auth::id()
            )
            ->latest()
            ->paginate(10);

        return view(
            'pages.qr-codes.index',
            [
                'shortUrls' => $shortUrls,
                'qrCodes' => $qrCodes,
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Generate Authenticated QR Code
    |--------------------------------------------------------------------------
    */
    public function generate(
        Request $request
    ): RedirectResponse {
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
        | Make Sure URL Belongs To Current User
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
        | Create QR Code Record
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

        return redirect()
            ->route(
                'qr-codes',
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
    | Generate Guest QR Code
    |--------------------------------------------------------------------------
    */
    public function generateGuest(
        Request $request
    ): RedirectResponse|JsonResponse {
        $settings = SystemSetting::current();

        /*
        |--------------------------------------------------------------------------
        | Check Guest QR Permission
        |--------------------------------------------------------------------------
        */
        if (!$settings->allow_guest_qr_codes) {

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' =>
                        'Guest QR code generation is currently disabled by the administrator.',
                ], 403);
            }

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Guest QR code generation is currently disabled by the administrator.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Validate Guest URL
        |--------------------------------------------------------------------------
        */
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
        | Store Temporary QR Data
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
        | Store Anonymous QR Generation
        |--------------------------------------------------------------------------
        */
        AnonymousGeneration::create([
            'type' => 'qr_code',
        ]);

        /*
        |--------------------------------------------------------------------------
        | AJAX Response
        |--------------------------------------------------------------------------
        */
        if ($request->expectsJson()) {

            return response()->json([
                'success' => true,
                'message' =>
                    'QR code generated successfully.',
                'download_url' =>
                    route(
                        'qr-codes.guest.download'
                    ),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Normal Browser Response
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
    | Download Guest QR Code
    |--------------------------------------------------------------------------
    */
    public function downloadGuest()
    {
        /*
        |--------------------------------------------------------------------------
        | Check Guest QR Permission Again
        |--------------------------------------------------------------------------
        |
        | This prevents a previously generated guest QR from being
        | downloaded after the administrator disables guest QR access.
        |
        */
        $settings = SystemSetting::current();

        if (!$settings->allow_guest_qr_codes) {
            abort(
                403,
                'Guest QR code generation is currently disabled by the administrator.'
            );
        }

        $guestQr = session(
            'guest_qr_data'
        );

        if (
            !is_array($guestQr)
            ||
            empty($guestQr['data'])
        ) {
            abort(
                404,
                'Guest QR code not found.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Build QR Code
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
        $writer =
            new PngWriter();

        $result =
            $writer->write(
                $qrCode
            );

        /*
        |--------------------------------------------------------------------------
        | Remove Temporary QR Data
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
    | Download Authenticated PNG
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

        $builder =
            $this->buildQrCode(
                $qrCode,
                $shortUrl->short_url
            );

        $writer =
            new PngWriter();

        $logo = null;

        if (
            $qrCode->logo_path
            &&
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
    | Download Authenticated SVG
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
    | Delete QR Code
    |--------------------------------------------------------------------------
    */
    public function destroy(
        QrCode $qrCode
    ): RedirectResponse {
        $this->authorizeQrCode(
            $qrCode
        );

        if (
            $qrCode->logo_path
            &&
            Storage::disk('public')->exists(
                $qrCode->logo_path
            )
        ) {

            Storage::disk('public')->delete(
                $qrCode->logo_path
            );
        }

        $qrCode->delete();

        return redirect()
            ->route('qr-codes')
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
    | Authorize QR Code
    |--------------------------------------------------------------------------
    */
    private function authorizeQrCode(
        QrCode $qrCode
    ): void {
        abort_unless(
            $qrCode->user_id === Auth::id(),
            403
        );
    }
}
