<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FrontController extends Controller
{

    public function testing()
    {
        return view('frontsite.testing');
    }

    public function index()
    {
        $assets = \App\Models\AssetsModel::get();
        return view('frontsite.index', compact('assets'));
    }

    public function profil()
    {
        return view('frontsite.profil');
    }

    public function layanan()
    {
        $assets = \App\Models\AssetsModel::get();
        return view('frontsite.layanan', compact('assets'));
    }

    public function servicedesk()
    {
        $this->generateCaptchaCode('captcha_code');
        return view('frontsite.servicedesk');
    }

    private function captchaSessionKey(Request $request): string
    {
        $for = $request->query('for');
        if ($for === 'login') {
            return 'login_captcha_code';
        } elseif ($for === 'ticket') {
            return 'captcha_code';
        }
        return 'captcha_code';
    }

    private function generateCaptchaCode(string $sessionKey = 'captcha_code'): string
    {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $code = '';

        for ($i = 0; $i < 6; $i++) {
            $code .= $characters[random_int(0, strlen($characters) - 1)];
        }

        session([$sessionKey => $code]);

        return $code;
    }

    public function captchaImage(Request $request)
    {
        $sessionKey = $this->captchaSessionKey($request);
        $code = session($sessionKey) ?: $this->generateCaptchaCode($sessionKey);

        $width = 180;
        $height = 50;

        $image = imagecreatetruecolor($width, $height);

        $background = imagecolorallocate($image, 234, 237, 240);
        imagefilledrectangle($image, 0, 0, $width, $height, $background);

        for ($i = 0; $i < 7; $i++) {
            $lineColor = imagecolorallocate($image, rand(80, 200), rand(80, 200), rand(80, 200));
            imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $lineColor);
        }

        for ($i = 0; $i < 120; $i++) {
            $dotColor = imagecolorallocate($image, rand(110, 210), rand(110, 210), rand(110, 210));
            imagesetpixel($image, rand(0, $width - 1), rand(0, $height - 1), $dotColor);
        }

        $x = 12;
        $fonts = [4, 5, 5, 4, 5, 4];
        for ($i = 0; $i < strlen($code); $i++) {
            $textColor = imagecolorallocate($image, rand(20, 70), rand(40, 110), rand(70, 180));
            imagestring($image, $fonts[$i], $x, rand(12, 20), $code[$i], $textColor);
            $x += 25;
        }

        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);

        return response($imageData, 200)
            ->header('Content-Type', 'image/png')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache');
    }

    public function refreshCaptcha(Request $request)
    {
        $sessionKey = $this->captchaSessionKey($request);
        $this->generateCaptchaCode($sessionKey);

        return response()->json([
            'success' => true,
            'captcha_url' => route('captcha.image', ['for' => $request->query('for')]) . '&v=' . Str::random(12)
        ]);
    }

    public function statistik()
    {
        $assets = \App\Models\AssetsModel::get();
        return view('frontsite.statistik', compact('assets'));
    }

    public function team()
    {
        return view('frontsite.team');
    }

    public function faq()
    {
        return view('frontsite.faq');
    }

    public function lacak()
    {
        return view('frontsite.lacak');
    }

    public function lacak_show($id)
    {
        $lacak = \App\Models\AssetsModel::where('tag', $id)->firstOrFail();
        return view('frontsite.lacak_show', compact('lacak'));
    }
}
