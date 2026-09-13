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
    | Generate QR Code
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
    | Download PNG
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
    | Download SVG
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