<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    private function redirectUrl(Request $request, string $provider): string
    {
        $base = $request->schemeAndHttpHost() . '/' . ltrim($request->getBaseUrl(), '/');
        return rtrim($base, '/') . '/auth/' . $provider . '/callback';
    }

    public function redirect(Request $request, string $provider)
    {
        if (!in_array($provider, ['google', 'facebook'])) {
            return redirect()->route('login')->with('error', 'مزود تسجيل الدخول غير مدعوم.');
        }

        session(['social_login_previous' => url()->previous()]);

        return Socialite::driver($provider)
            ->redirectUrl($this->redirectUrl($request, $provider))
            ->redirect();
    }

    public function callback(Request $request, string $provider)
    {
        if (!in_array($provider, ['google', 'facebook'])) {
            return redirect()->route('login')->with('error', 'مزود تسجيل الدخول غير مدعوم.');
        }

        try {
            $socialUser = Socialite::driver($provider)
                ->redirectUrl($this->redirectUrl($request, $provider))
                ->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'فشل تسجيل الدخول عبر ' . $provider . '. يرجى المحاولة مرة أخرى.');
        }

        $existingAccount = SocialAccount::where('provider', $provider)
            ->where('provider_id', $socialUser->getId())
            ->first();

        if ($existingAccount) {
            Auth::login($existingAccount->user);
            return redirect()->intended(route('home'));
        }

        $existingUser = User::where('email', $socialUser->getEmail())->first();

        if ($existingUser) {
            $existingUser->socialAccounts()->create([
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
            ]);

            Auth::login($existingUser);
            return redirect()->intended(route('home'));
        }

        $user = User::create([
            'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? $provider . '_user',
            'email' => $socialUser->getEmail() ?? 'user_' . Str::random(8) . '@' . $provider . '.com',
            'password' => bcrypt(Str::random(32)),
            'role' => 'customer',
            'tenant_id' => 1,
            'is_active' => true,
        ]);

        $user->socialAccounts()->create([
            'provider' => $provider,
            'provider_id' => $socialUser->getId(),
            'avatar' => $socialUser->getAvatar(),
        ]);

        Auth::login($user);
        return redirect()->intended(route('home'));
    }
}
