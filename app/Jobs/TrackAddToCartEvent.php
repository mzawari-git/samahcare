<?php

namespace App\Jobs;

use Modules\Commerce\Services\AdvertisingTrackingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TrackAddToCartEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 2;
    public int $backoff = 30;

    public function __construct(
        public int $productId,
        public string $productName,
        public float $price,
        public int $quantity,
        public ?int $userId = null
    ) {}

    public function handle(AdvertisingTrackingService $trackingService): void
    {
        try {
            $trackingService->trackAddToCart(
                $this->productId,
                $this->productName,
                $this->price,
                $this->quantity,
                $this->userId
            );

            Log::info('AddToCart tracking job completed', [
                'product_id' => $this->productId,
            ]);

        } catch (\Exception $e) {
            Log::error('AddToCart tracking job failed', [
                'product_id' => $this->productId,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
