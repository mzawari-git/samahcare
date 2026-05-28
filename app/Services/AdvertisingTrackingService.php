<?php

namespace App\Services;

use App\Models\MarketingSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdvertisingTrackingService
{
    private bool $fbPixelEnabled;
    private bool $fbCapiEnabled;
    private ?string $fbPixelId;
    private ?string $fbAccessToken;
    private ?string $fbTestCode;

    private bool $ttPixelEnabled;
    private bool $ttCapiEnabled;
    private ?string $ttPixelId;
    private ?string $ttAccessToken;

    private bool $trackingEnabled;
    private bool $testMode;
    private bool $asyncMode;

    public function __construct()
    {
        $this->loadSettings();
    }

    private function loadSettings(): void
    {
        $this->trackingEnabled = MarketingSetting::get('tracking_enabled', true);
        $this->testMode = MarketingSetting::get('tracking_test_mode', false);
        $this->asyncMode = MarketingSetting::get('tracking_async_mode', true);

        $this->fbPixelEnabled = MarketingSetting::get('facebook_pixel_enabled', false);
        $this->fbCapiEnabled = MarketingSetting::get('facebook_capi_enabled', false);
        $this->fbPixelId = MarketingSetting::get('facebook_pixel_id');
        $this->fbAccessToken = MarketingSetting::get('facebook_access_token');
        $this->fbTestCode = MarketingSetting::get('facebook_test_event_code');

        $this->ttPixelEnabled = MarketingSetting::get('tiktok_pixel_enabled', false);
        $this->ttCapiEnabled = MarketingSetting::get('tiktok_capi_enabled', false);
        $this->ttPixelId = MarketingSetting::get('tiktok_pixel_id');
        $this->ttAccessToken = MarketingSetting::get('tiktok_access_token');
    }

    public function getBrowserPixelScript(): string
    {
        if (!$this->trackingEnabled) return '';

        $scripts = [];

        if ($this->fbPixelEnabled && $this->fbPixelId) {
            $scripts[] = $this->buildFacebookPixelScript();
        }

        if ($this->ttPixelEnabled && $this->ttPixelId) {
            $scripts[] = $this->buildTikTokPixelScript();
        }

        return implode("\n", $scripts);
    }

    public function getBrowserPixelNoscript(): string
    {
        if (!$this->trackingEnabled || !$this->fbPixelEnabled || !$this->fbPixelId) return '';
        return '<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=' . e($this->fbPixelId) . '&ev=PageView&noscript=1"/></noscript>';
    }

    private function buildFacebookPixelScript(): string
    {
        $pixelId = e($this->fbPixelId);
        return <<<JS
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init','{$pixelId}');
fbq('track','PageView');
</script>
JS;
    }

    private function buildTikTokPixelScript(): string
    {
        $pixelId = e($this->ttPixelId);
        return <<<JS
<script>
!function(w,d,t){w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"];ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e};ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};var o=document.createElement("script");o.type="text/javascript",o.async=!0,o.src=i+"?sdkid="+e+"&lib="+t;var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(o,a)};ttq.load('{$pixelId}');ttq.page();}(window,document,'ttq');
</script>
JS;
    }

    public function trackViewContent(array $product, ?array $userData = null): array
    {
        if (!$this->trackingEnabled) return ['success' => false, 'reason' => 'tracking_disabled'];

        $eventData = $this->buildViewContentData($product);
        $results = [];

        if ($this->fbCapiEnabled && $this->fbAccessToken) {
            $results['facebook'] = $this->sendFacebookCAPI('ViewContent', $eventData, $userData);
        }

        return $results;
    }

    public function trackAddToCart(array $product, int $quantity = 1, ?array $userData = null): array
    {
        if (!$this->trackingEnabled) return ['success' => false, 'reason' => 'tracking_disabled'];

        $eventData = $this->buildAddToCartData($product, $quantity);
        $results = [];

        if ($this->fbCapiEnabled && $this->fbAccessToken) {
            $results['facebook'] = $this->sendFacebookCAPI('AddToCart', $eventData, $userData);
        }

        return $results;
    }

    public function trackInitiateCheckout(array $cartData, ?array $userData = null): array
    {
        if (!$this->trackingEnabled) return ['success' => false, 'reason' => 'tracking_disabled'];

        $eventData = $this->buildCheckoutData($cartData);
        $results = [];

        if ($this->fbCapiEnabled && $this->fbAccessToken) {
            $results['facebook'] = $this->sendFacebookCAPI('InitiateCheckout', $eventData, $userData);
        }

        return $results;
    }

    public function trackPurchase($order, ?array $userData = null): array
    {
        if (!$this->trackingEnabled) return ['success' => false, 'reason' => 'tracking_disabled'];

        $this->loadSettings();
        $eventData = $this->buildPurchaseData($order);
        $results = [];

        if ($this->fbCapiEnabled && $this->fbAccessToken && $this->fbPixelId) {
            $fbResult = $this->sendFacebookCAPI('Purchase', $eventData, $userData);
            $results['facebook'] = $fbResult;

            if ($order instanceof \Illuminate\Database\Eloquent\Model) {
                $order->update([
                    'meta_capi_sent' => $fbResult['success'] ?? false,
                    'meta_capi_sent_at' => now(),
                    'meta_capi_response' => json_encode($fbResult),
                ]);
            }
        }

        if ($this->ttCapiEnabled && $this->ttAccessToken && $this->ttPixelId) {
            $ttData = $this->buildTikTokPurchaseData($order);
            $ttResult = $this->sendTikTokEventsAPI('Purchase', $ttData);
            $results['tiktok'] = $ttResult;
        }

        return $results;
    }

    private function sendFacebookCAPI(string $eventName, array $eventData, ?array $userData = null): array
    {
        try {
            $payload = [
                'data' => [[
                    'event_name' => $eventName,
                    'event_time' => time(),
                    'event_id' => $eventName . '_' . uniqid(),
                    'event_source_url' => request()->fullUrl(),
                    'action_source' => 'website',
                    'user_data' => $this->buildFacebookUserData($userData),
                    'custom_data' => $eventData,
                ]],
            ];

            if ($this->fbTestCode) {
                $payload['test_event_code'] = $this->fbTestCode;
            }

            $url = "https://graph.facebook.com/v18.0/{$this->fbPixelId}/events?access_token={$this->fbAccessToken}";

            $response = Http::timeout(10)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, $payload);

            $success = $response->successful();
            $body = $response->json();

            if (!$success) {
                Log::warning('Facebook CAPI failed', [
                    'event' => $eventName,
                    'status' => $response->status(),
                    'body' => $body,
                ]);
            }

            return ['success' => $success, 'response' => $body];
        } catch (\Exception $e) {
            Log::error('Facebook CAPI exception', [
                'event' => $eventName,
                'error' => $e->getMessage(),
            ]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    private function sendTikTokEventsAPI(string $eventName, array $eventData): array
    {
        try {
            $payload = [
                'pixel_code' => $this->ttPixelId,
                'event' => $eventName,
                'event_id' => $eventName . '_' . uniqid(),
                'timestamp' => now()->toIso8601String(),
                'context' => [
                    'page' => ['url' => request()->fullUrl()],
                    'user_agent' => request()->userAgent(),
                    'ip' => request()->ip(),
                ],
                'properties' => $eventData,
            ];

            $response = Http::timeout(10)
                ->withHeaders([
                    'Access-Token' => $this->ttAccessToken,
                    'Content-Type' => 'application/json',
                ])
                ->post('https://analytics.tiktok.com/api/v2/offline/events', $payload);

            $success = $response->successful();

            if (!$success) {
                Log::warning('TikTok Events API failed', [
                    'event' => $eventName,
                    'status' => $response->status(),
                ]);
            }

            return ['success' => $success, 'response' => $response->json()];
        } catch (\Exception $e) {
            Log::error('TikTok Events API exception', [
                'event' => $eventName,
                'error' => $e->getMessage(),
            ]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    private function buildFacebookUserData(?array $userData = null): array
    {
        $data = [];

        if ($userData) {
            if (!empty($userData['email'])) $data['em'] = [hash('sha256', $userData['email'])];
            if (!empty($userData['phone'])) $data['ph'] = [hash('sha256', preg_replace('/[^0-9]/', '', $userData['phone']))];
            if (!empty($userData['name'])) $data['fn'] = [hash('sha256', $userData['name'])];
        }

        $data['client_ip_address'] = request()->ip();
        $data['client_user_agent'] = request()->userAgent();

        if (!empty(request()->cookie('_fbp'))) {
            $data['_fbp'] = request()->cookie('_fbp');
        }
        if (!empty(request()->cookie('_fbc'))) {
            $data['_fbc'] = request()->cookie('_fbc');
        }

        return $data;
    }

    private function buildViewContentData(array $product): array
    {
        return [
            'content_ids' => [$product['sku'] ?? $product['id'] ?? ''],
            'content_name' => $product['name'] ?? '',
            'content_category' => $product['category'] ?? '',
            'content_type' => 'product',
            'value' => $product['price'] ?? 0,
            'currency' => 'ILS',
        ];
    }

    private function buildAddToCartData(array $product, int $quantity): array
    {
        return [
            'content_ids' => [$product['sku'] ?? $product['id'] ?? ''],
            'content_name' => $product['name'] ?? '',
            'content_type' => 'product',
            'contents' => [[
                'id' => $product['sku'] ?? $product['id'] ?? '',
                'quantity' => $quantity,
                'item_price' => $product['price'] ?? 0,
            ]],
            'value' => ($product['price'] ?? 0) * $quantity,
            'currency' => 'ILS',
        ];
    }

    private function buildCheckoutData(array $cartData): array
    {
        $contents = [];
        foreach ($cartData['items'] ?? [] as $item) {
            $contents[] = [
                'id' => $item['sku'] ?? $item['id'] ?? '',
                'quantity' => $item['quantity'] ?? 1,
                'item_price' => $item['price'] ?? 0,
            ];
        }

        return [
            'contents' => $contents,
            'num_items' => count($contents),
            'value' => $cartData['total'] ?? 0,
            'currency' => 'ILS',
        ];
    }

    private function buildPurchaseData($order): array
    {
        $contents = [];
        foreach ($order->items ?? [] as $item) {
            $contents[] = [
                'id' => $item->product_sku ?? '',
                'quantity' => $item->quantity,
                'item_price' => (float) $item->unit_price,
            ];
        }

        return [
            'contents' => $contents,
            'content_type' => 'product',
            'num_items' => $order->items->sum('quantity') ?? 0,
            'value' => (float) $order->total_amount,
            'currency' => $order->currency ?? 'ILS',
            'order_id' => $order->order_number ?? $order->id,
        ];
    }

    private function buildTikTokPurchaseData($order): array
    {
        $contents = [];
        foreach ($order->items ?? [] as $item) {
            $contents[] = [
                'content_id' => $item->product_sku ?? '',
                'content_name' => $item->product_name ?? '',
                'quantity' => $item->quantity,
                'price' => (float) $item->unit_price,
            ];
        }

        return [
            'contents' => $contents,
            'value' => (float) $order->total_amount,
            'currency' => $order->currency ?? 'ILS',
            'order_id' => $order->order_number ?? $order->id,
        ];
    }

    public function isEnabled(): bool { return $this->trackingEnabled; }
    public function isFbPixelEnabled(): bool { return $this->fbPixelEnabled && $this->fbPixelId; }
    public function isTtPixelEnabled(): bool { return $this->ttPixelEnabled && $this->ttPixelId; }
    public function isAsyncMode(): bool { return $this->asyncMode; }
    public function isTestMode(): bool { return $this->testMode; }
}
