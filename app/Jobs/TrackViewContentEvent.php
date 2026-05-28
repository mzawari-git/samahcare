<?php

namespace App\Jobs;

use Modules\Commerce\Services\AdvertisingTrackingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TrackViewContentEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 2;
    public int $backoff = 30;

    public function __construct(
        public array $productData,
        public ?int $userId = null
    ) {}

    public function handle(AdvertisingTrackingService $trackingService): void
    {
        try {
            $trackingService->trackViewContent($this->productData, $this->userId);

            Log::info('ViewContent tracking job completed', [
                'product_id' => $this->productData['id'] ?? null,
            ]);

        } catch (\Exception $e) {
            Log::error('ViewContent tracking job failed', [
                'product_id' => $this->productData['id'] ?? null,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
