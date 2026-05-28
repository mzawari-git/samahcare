<?php

use Illuminate\Support\Facades\Route;
use Modules\CustomAdmin\Http\Controllers\MetaWebhookController;

Route::get('/api/health', function () {
    return response()->json(['status' => 'ok', 'time' => now()]);
});

Route::any('/meta/webhook', [MetaWebhookController::class, 'receiveWebhook'])->name('api.meta.webhook');
