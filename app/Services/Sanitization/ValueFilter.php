<?php

namespace App\Services\Sanitization;

use Illuminate\Support\Facades\Log;

class ValueFilter implements SanitizationStepInterface
{
    public function getName(): string
    {
        return 'Value & Margin Filter';
    }

    public function process(array $payload, array $context = []): array
    {
        $minValue = (float) config('tracking.filtering.min_order_value', 0);

        if ($minValue > 0) {
            $value = (float) ($payload['data']['value'] ?? $payload['data']['price'] ?? 0);
            $currency = $payload['data']['currency'] ?? 'ILS';

            if ($minValue > 0 && $value < $minValue) {
                Log::info('Event blocked by value filter', [
                    'value' => $value,
                    'min_value' => $minValue,
                    'currency' => $currency,
                    'platform' => $context['platform'] ?? 'unknown',
                ]);
                return array_merge($payload, [
                    '_blocked' => true,
                    '_block_reason' => "Order value {$value} below minimum {$minValue}",
                ]);
            }
        }

        return $payload;
    }
}
