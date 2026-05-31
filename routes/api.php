<?php

use Illuminate\Support\Facades\Route;
use Modules\CustomAdmin\Http\Controllers\MetaWebhookController;

Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'time' => now()]);
});

Route::get('/meta/webhook', [MetaWebhookController::class, 'verify'])->name('api.meta.webhook.verify');
Route::post('/meta/webhook', [MetaWebhookController::class, 'receiveWebhook'])->name('api.meta.webhook');

Route::post('/track/behavior', [\App\Http\Controllers\Api\BehavioralController::class, 'store'])
    ->name('api.behavioral');
Route::get('/track/behavior/score', [\App\Http\Controllers\Api\BehavioralController::class, 'score'])
    ->name('api.behavioral.score');

Route::post('/track/fingerprint', [\App\Http\Controllers\Api\FingerprintController::class, 'store'])
    ->name('api.fingerprint');
