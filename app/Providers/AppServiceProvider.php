<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Helpers\SettingsHelper;
use App\Services\IdentityService;
use App\Services\EventSourcingService;
use App\Services\AISanitizerService;
use App\Services\AI\OpenAIProvider;
use App\Services\AI\ClaudeProvider;
use App\Services\AI\LlamaProvider;
use App\Services\AdAccountHealthService;
use App\Services\AdSpendMonitorService;
use App\Services\AdAutoPauseService;
use App\Services\AlertNotifier;
use App\Services\TrafficQualityService;
use App\Services\LtvMultiplierService;
use App\Services\MultiPixelService;
use App\Services\Sanitization\SanitizationPipeline;
use App\Services\Sanitization\TriggerWordFilter;
use App\Services\Sanitization\LLMFilter;
use App\Services\Sanitization\PolicyChecker;
use App\Services\Sanitization\ValueFilter;
use App\Services\Sanitization\JunkFilter;
use Modules\AICompliance\Services\ContentModerationService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(\App\Services\GoogleAdsService::class, function ($app) {
            return new \App\Services\GoogleAdsService();
        });

        $this->app->singleton(\App\Services\SnapchatService::class, function ($app) {
            return new \App\Services\SnapchatService();
        });

        $this->app->singleton(\App\Services\PinterestService::class, function ($app) {
            return new \App\Services\PinterestService();
        });

        $this->app->singleton(\App\Services\TwitterService::class, function ($app) {
            return new \App\Services\TwitterService();
        });

        $this->app->singleton(\App\Services\LinkedInService::class, function ($app) {
            return new \App\Services\LinkedInService();
        });

        $this->app->singleton(ContentModerationService::class, function ($app) {
            return new ContentModerationService();
        });

        $this->app->singleton(IdentityService::class, function ($app) {
            return new IdentityService();
        });

        $this->app->singleton(EventSourcingService::class, function ($app) {
            return new EventSourcingService();
        });

        $this->app->singleton(OpenAIProvider::class, function ($app) {
            return new OpenAIProvider();
        });

        $this->app->singleton(ClaudeProvider::class, function ($app) {
            return new ClaudeProvider();
        });

        $this->app->singleton(LlamaProvider::class, function ($app) {
            return new LlamaProvider();
        });

        $this->app->singleton(AISanitizerService::class, function ($app) {
            return new AISanitizerService(
                $app->make(OpenAIProvider::class),
                $app->make(ClaudeProvider::class),
                $app->make(LlamaProvider::class),
            );
        });

        $this->app->singleton(AdAccountHealthService::class, function ($app) {
            return new AdAccountHealthService();
        });

        $this->app->singleton(LtvMultiplierService::class, function ($app) {
            return new LtvMultiplierService();
        });

        $this->app->singleton(MultiPixelService::class, function ($app) {
            return new MultiPixelService();
        });

        $this->app->singleton(AlertNotifier::class, function ($app) {
            return new AlertNotifier();
        });

        $this->app->singleton(TrafficQualityService::class, function ($app) {
            return new TrafficQualityService();
        });

        $this->app->singleton(AdSpendMonitorService::class, function ($app) {
            return new AdSpendMonitorService(
                $app->make(\App\Services\Meta\FacebookGraphService::class),
                $app->make(\App\Services\MetaReportingService::class),
                $app->make(AdAccountHealthService::class),
            );
        });

        $this->app->singleton(AdAutoPauseService::class, function ($app) {
            return new AdAutoPauseService(
                $app->make(\App\Services\Meta\FacebookGraphService::class),
                $app->make(AdAccountHealthService::class),
                $app->make(AlertNotifier::class),
            );
        });

        $this->app->singleton(SanitizationPipeline::class, function ($app) {
            return (new SanitizationPipeline())
                ->addStep(new TriggerWordFilter())
                ->addStep(new LLMFilter($app->make(AISanitizerService::class)))
                ->addStep(new PolicyChecker())
                ->addStep(new ValueFilter())
                ->addStep(new JunkFilter());
        });

        if (class_exists(\Laravel\Pulse\PulseServiceProvider::class)) {
            $this->app->register(\Laravel\Pulse\PulseServiceProvider::class);
        }
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
            'site_theme' => 'minimal',
            'facebook_pixel_enabled' => '1',
            'payment_bank_enabled' => '0',
            'payment_jawwal_enabled' => '0',
            'payment_reflect_enabled' => '0',
        ];

        View::composer('*', function ($view) use ($defaultSettings) {
            $settings = SettingsHelper::getAll();
            $s = array_merge($defaultSettings, $settings);

            // Read user theme preferences from cookies (persist across logout)
            $knownThemes = ['clean','rose','midnight','natural','forest','minimal','ocean','sunset','luxury'];
            $activeTheme = $_COOKIE['سماح كير _color'] ?? $s['site_theme'] ?? 'clean';
            if (!in_array($activeTheme, $knownThemes)) {
                $activeTheme = 'clean';
            }

            // Default: derive architecture from the active theme color
            $layoutArchitecture = match($activeTheme) {
                'clean' => 'clean-minimal',
                'rose', 'midnight' => 'cyber-lab',
                'natural', 'forest' => 'organic-spa',
                'minimal', 'ocean' => 'editorial',
                'sunset', 'luxury' => 'luxury-boutique',
                default => 'clean-minimal',
            };
            // Architecture cookie overrides (user explicitly chose a layout)
            if (isset($_COOKIE['سماح كير _arch'])) {
                $ca = $_COOKIE['سماح كير _arch'];
                if (in_array($ca, ['clean-minimal','cyber-lab','organic-spa','editorial','luxury-boutique'])) {
                    $layoutArchitecture = $ca;
                }
            }

            $mode = $_COOKIE['سماح كير _mode'] ?? 'light';
            $isLightTheme = $mode !== 'dark';

            $view->with('layoutArchitecture', $layoutArchitecture);
            $view->with('layoutPath', 'frontend.layouts.' . $layoutArchitecture . '.app');
            $view->with('activeTheme', $activeTheme);
            $view->with('isLightTheme', $isLightTheme);

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
                'twitter_url' => $s['twitter_url'] ?? '',
                'linkedin_url' => $s['linkedin_url'] ?? '',
                'youtube_url' => $s['youtube_url'] ?? '',
                'snapchat_url' => $s['snapchat_url'] ?? '',
                'pinterest_url' => $s['pinterest_url'] ?? '',
                'currency' => $s['currency'] ?? 'ILS',
                'currency_symbol' => $s['currency_symbol'] ?? '₪',
                'site_theme' => $s['site_theme'] ?? 'rose',
                'facebook_pixel_id' => $s['facebook_pixel_id'] ?? '',
                'facebook_pixel_enabled' => $s['facebook_pixel_enabled'] ?? '1',
                'payment_bank_enabled' => $s['payment_bank_enabled'] ?? '0',
                'payment_jawwal_enabled' => $s['payment_jawwal_enabled'] ?? '0',
                'payment_reflect_enabled' => $s['payment_reflect_enabled'] ?? '0',
            ]);
        });

        // Share identity data with all views
        View::composer('*', function ($view) {
            try {
                $identity = request()?->get('_identity');
                $view->with('_identity', $identity);
            } catch (\Exception $e) {
                $view->with('_identity', null);
            }
        });

        // Share default cart count (service booking system - no traditional cart)
        View::composer('*', function ($view) {
            $view->with('cartCount', 0);
        });
    }
}
