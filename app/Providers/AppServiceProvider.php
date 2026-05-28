<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Helpers\SettingsHelper;
use App\Models\Cart;
use Modules\Commerce\Services\CartService;
use Modules\Commerce\Services\OrderProcessor;
use App\Services\PricingEngine;
use Modules\Commerce\Services\MetaCapiService;
use Modules\Commerce\Services\AdvertisingTrackingService;
use Modules\AICompliance\Services\ContentModerationService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(PricingEngine::class, function ($app) {
            return new PricingEngine();
        });

        $this->app->singleton(CartService::class, function ($app) {
            return new CartService($app->make(PricingEngine::class));
        });

        $this->app->singleton(MetaCapiService::class, function ($app) {
            return new MetaCapiService();
        });

        $this->app->singleton(AdvertisingTrackingService::class, function ($app) {
            return new AdvertisingTrackingService();
        });

        $this->app->singleton(ContentModerationService::class, function ($app) {
            return new ContentModerationService();
        });

        $this->app->singleton(OrderProcessor::class, function ($app) {
            return new OrderProcessor(
                $app->make(PricingEngine::class),
                $app->make(CartService::class),
                $app->make(MetaCapiService::class)
            );
        });
    }

    public function boot(): void
    {
        try {
            $dbSettings = \App\Models\Setting::pluck('value', 'key')->toArray();

            if (!empty($dbSettings['google_client_id']) && !empty($dbSettings['google_client_secret'])) {
                config([
                    'services.google.client_id' => $dbSettings['google_client_id'],
                    'services.google.client_secret' => $dbSettings['google_client_secret'],
                ]);
            }

            if (!empty($dbSettings['facebook_client_id']) && !empty($dbSettings['facebook_client_secret'])) {
                config([
                    'services.facebook.client_id' => $dbSettings['facebook_client_id'],
                    'services.facebook.client_secret' => $dbSettings['facebook_client_secret'],
                ]);
            }
        } catch (\Exception $e) {
            // Table might not exist yet (first migration)
        }

        $defaultSettings = [
            'site_name' => config('app.name'),
            'site_name_ar' => config('app.name'),
            'site_name_en' => config('app.name'),
            'contact_email' => 'info@jenincare.com',
            'currency' => 'ILS',
            'currency_symbol' => '₪',
            'shipping_cost' => 25,
            'free_shipping_min' => 200,
            'site_theme' => 'rose',
            'facebook_pixel_enabled' => '1',
            'payment_bank_enabled' => '0',
            'payment_jawwal_enabled' => '0',
            'payment_reflect_enabled' => '0',
        ];

        View::composer('*', function ($view) use ($defaultSettings) {
            $settings = SettingsHelper::getAll();
            $s = array_merge($defaultSettings, $settings);

            $view->with('siteSettings', [
                'site_name' => $s['site_name'] ?? $s['site_name_ar'] ?? config('app.name'),
                'site_name_ar' => $s['site_name_ar'] ?? config('app.name'),
                'site_name_en' => $s['site_name_en'] ?? config('app.name'),
                'site_logo' => $s['site_logo'] ?? null,
                'site_logo_url' => SettingsHelper::siteLogo(),
                'site_favicon' => $s['site_favicon'] ?? null,
                'site_favicon_url' => SettingsHelper::siteFavicon(),
                'site_description' => $s['site_description_ar'] ?? $s['site_description'] ?? '',
                'site_email' => $s['contact_email'] ?? $s['site_email'] ?? 'info@jenincare.com',
                'contact_email' => $s['contact_email'] ?? $s['site_email'] ?? 'info@jenincare.com',
                'site_phone' => $s['contact_phone'] ?? $s['site_phone'] ?? '',
                'contact_phone' => $s['contact_phone'] ?? $s['site_phone'] ?? '',
                'whatsapp_number' => $s['whatsapp_number'] ?? $s['site_whatsapp'] ?? '',
                'site_whatsapp' => $s['whatsapp_number'] ?? $s['site_whatsapp'] ?? '',
                'address' => $s['address'] ?? $s['site_address'] ?? '',
                'site_address' => $s['address'] ?? $s['site_address'] ?? '',
                'facebook_url' => $s['facebook_url'] ?? $s['social_facebook'] ?? '',
                'social_facebook' => $s['facebook_url'] ?? $s['social_facebook'] ?? '',
                'instagram_url' => $s['instagram_url'] ?? $s['social_instagram'] ?? '',
                'social_instagram' => $s['instagram_url'] ?? $s['social_instagram'] ?? '',
                'tiktok_url' => $s['tiktok_url'] ?? $s['social_tiktok'] ?? '',
                'social_tiktok' => $s['tiktok_url'] ?? $s['social_tiktok'] ?? '',
                'twitter_url' => $s['twitter_url'] ?? $s['social_twitter'] ?? '',
                'linkedin_url' => $s['linkedin_url'] ?? '',
                'youtube_url' => $s['youtube_url'] ?? '',
                'currency' => $s['currency'] ?? 'ILS',
                'currency_symbol' => $s['currency_symbol'] ?? '₪',
                'shipping_cost' => floatval($s['shipping_cost'] ?? 25),
                'free_shipping_min' => floatval($s['free_shipping_threshold'] ?? $s['free_shipping_min'] ?? 200),
                'site_theme' => $s['site_theme'] ?? 'rose',
                'facebook_pixel_id' => $s['facebook_pixel_id'] ?? '',
                'facebook_pixel_enabled' => $s['facebook_pixel_enabled'] ?? '1',
                'payment_bank_enabled' => $s['payment_bank_enabled'] ?? '0',
                'payment_jawwal_enabled' => $s['payment_jawwal_enabled'] ?? '0',
                'payment_reflect_enabled' => $s['payment_reflect_enabled'] ?? '0',
            ]);
        });

        // Share cart count with all views
        View::composer('*', function ($view) {
            try {
                if (Auth::check()) {
                    $cart = Cart::where('user_id', Auth::id())->where('is_active', true)->first();
                } else {
                    $cart = Cart::where('session_id', Session::getId())->where('is_active', true)->first();
                }
                $view->with('cartCount', $cart ? $cart->items()->sum('quantity') : 0);
            } catch (\Exception $e) {
                $view->with('cartCount', 0);
            }
        });
    }
}
