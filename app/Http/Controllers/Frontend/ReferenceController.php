<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Helpers\SettingsHelper;
use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    public function show($token)
    {
        $storedToken = SettingsHelper::get('reference_page_token');
        $isEnabled = SettingsHelper::get('reference_page_enabled', '0');

        if ($isEnabled !== '1' || !$storedToken || $token !== $storedToken) {
            abort(404);
        }

        return response()
            ->view('frontend.pages.reference')
            ->header('X-Robots-Tag', 'noindex, nofollow, noarchive, nosnippet');
    }
}
