<?php

namespace App\Http\Middleware;

use App\Models\UserSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetUserLocale
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        if (Auth::check()) {

            $language = UserSetting::where(
                'user_id',
                Auth::id()
            )->value('language');

            if ($language === 'Bangla') {
                App::setLocale('bn');
            } else {
                App::setLocale('en');
            }
        }

        return $next($request);
    }
}