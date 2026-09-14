<?php

namespace App\Http\Controllers;

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
    | QR Code Generator Page
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $shortUrls = ShortUrl::where('user_id', Auth::id())
            ->latest()
            ->get();

        $qrCodes = QrCode::with('shortUrl')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pages.qr-codes.index', [
            'shortUrls' => $shortUrls,
            'qrCodes' => $qrCodes,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Generate QR Code - Authenticated User
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
        | Make Sure Short URL Belongs To Current User
        |--------------------------------------------------------------------------
        */

        $shortUrl = ShortUrl::where('id', $validated['short_url_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Store Logo
        |--------------------------------------------------------------------------
        */

        $logoPath = null;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store(
                'qr-logos',
                'public'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Save QR Configuration
        |--------------------------------------------------------------------------
        */

        $qrCodeRecord = QrCode::create([
            'user_id' => Auth::id(),
            'short_url_id' => $shortUrl->id,
            'size' => $validated['size'],
            'foreground_color' => $validated['foreground_color'],
            'background_color' => $validated['background_color'],
            'logo_path' => $logoPath,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect Back
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('qr-codes', [
                'qr' => $qrCodeRecord->id,
            ])
            ->with(
                'success',
                'QR code generated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Generate Guest QR Code
    |--------------------------------------------------------------------------
    |
    | Guest QR codes are NOT stored in the database.
    |
    | The original long URL is stored temporarily in the
    | user's session and the QR image is generated when
    | the user clicks Download QR Code.
    |
    */

    public function generateGuest(Request $request)
    {
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
        |
        | The QR code contains the ORIGINAL LONG URL.
        |
        */

        $request->session()->put('guest_qr', [
            'data' => $validated['original_url'],

            'size' => 400,

            'foreground_color' => '#111827',

            'background_color' => '#FFFFFF',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect To Landing Page
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('home')
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
        | Get Guest QR Data From Session
        |--------------------------------------------------------------------------
        */

        $guestQr = session('guest_qr');


        /*
        |--------------------------------------------------------------------------
        | Make Sure QR Data Exists
        |--------------------------------------------------------------------------
        */

        if (
            !is_array($guestQr) ||
            empty($guestQr['data'])
        ) {
            abort(404, 'Guest QR code not found.');
        }


        /*
        |--------------------------------------------------------------------------
        | Build QR Code
        |--------------------------------------------------------------------------
        */

        $qrCode = new EndroidQrCode(
            data: $guestQr['data'],

            encoding: new Encoding('UTF-8'),

            errorCorrectionLevel:
                ErrorCorrectionLevel::High,

            size:
                (int) ($guestQr['size'] ?? 400),

            margin: 10,

            roundBlockSizeMode:
                RoundBlockSizeMode::Margin,

            foregroundColor:
                $this->hexToColor(
                    $guestQr['foreground_color'] ?? '#111827'
                ),

            backgroundColor:
                $this->hexToColor(
                    $guestQr['background_color'] ?? '#FFFFFF'
                )
        );


        /*
        |--------------------------------------------------------------------------
        | Generate PNG
        |--------------------------------------------------------------------------
        */

        $writer = new PngWriter();

        $result = $writer->write($qrCode);


        /*
        |--------------------------------------------------------------------------
        | Download PNG
        |--------------------------------------------------------------------------
        */

        return response(
            $result->getString(),
            200,
            [
                'Content-Type' => 'image/png',

                'Content-Disposition' =>
                    'attachment; filename="guest-qr-code.png"',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Download PNG - Authenticated User
    |--------------------------------------------------------------------------
    */

    public function downloadPng(QrCode $qrCode)
    {
        $this->authorizeQrCode($qrCode);

        $shortUrl = $qrCode->shortUrl;

        $builder = $this->buildQrCode(
            $qrCode,
            $shortUrl->short_url
        );

        $writer = new PngWriter();

        $logo = null;

        if (
            $qrCode->logo_path &&
            Storage::disk('public')->exists(
                $qrCode->logo_path
            )
        ) {
            $logo = new Logo(
                path: Storage::disk('public')->path(
                    $qrCode->logo_path
                ),
                resizeToWidth: (int) ($qrCode->size * 0.18),
                punchoutBackground: true
            );
        }

        $result = $writer->write(
            $builder,
            $logo
        );

        return response(
            $result->getString(),
            200,
            [
                'Content-Type' => 'image/png',

                'Content-Disposition' =>
                    'attachment; filename="qr-code-' .
                    $qrCode->id .
                    '.png"',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Download SVG - Authenticated User
    |--------------------------------------------------------------------------
    */

    public function downloadSvg(QrCode $qrCode)
    {
        $this->authorizeQrCode($qrCode);

        $shortUrl = $qrCode->shortUrl;

        $builder = $this->buildQrCode(
            $qrCode,
            $shortUrl->short_url
        );

        $writer = new SvgWriter();

        $result = $writer->write($builder);

        return response(
            $result->getString(),
            200,
            [
                'Content-Type' => 'image/svg+xml',

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

    public function destroy(QrCode $qrCode)
    {
        $this->authorizeQrCode($qrCode);

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
        | Delete Database Record
        |--------------------------------------------------------------------------
        */

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
            data: $data,

            encoding: new Encoding('UTF-8'),

            errorCorrectionLevel:
                ErrorCorrectionLevel::High,

            size: $qrCode->size,

            margin: 10,

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
    | Convert HEX Color
    |--------------------------------------------------------------------------
    */

    private function hexToColor(string $hex): Color
    {
        $hex = ltrim($hex, '#');

        return new Color(
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2))
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
