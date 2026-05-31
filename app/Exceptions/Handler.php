<?php

namespace App\Exceptions;

use App\Services\AlertNotifier;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            $this->notifyCriticalException($e);
        });
    }

    private function notifyCriticalException(Throwable $e): void
    {
        $ignoredExceptions = [
            \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class,
            \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException::class,
            \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException::class,
            \Illuminate\Validation\ValidationException::class,
            \Illuminate\Auth\AuthenticationException::class,
        ];

        foreach ($ignoredExceptions as $ignored) {
            if ($e instanceof $ignored) {
                return;
            }
        }

        try {
            if (app()->bound(AlertNotifier::class)) {
                $notifier = app(AlertNotifier::class);
                $notifier->send([
                    'type' => 'exception',
                    'title' => 'Application Exception: ' . class_basename($e),
                    'body' => sprintf(
                        "Message: %s\nFile: %s\nLine: %d\nURL: %s\nMethod: %s",
                        $e->getMessage(),
                        $e->getFile(),
                        $e->getLine(),
                        request()?->fullUrl() ?? 'CLI',
                        request()?->method() ?? 'CLI'
                    ),
                    'severity' => 'critical',
                    'platform' => 'backend',
                ]);
            }
        } catch (\Exception $notificationException) {
            Log::warning('Failed to send exception notification', [
                'error' => $notificationException->getMessage(),
            ]);
        }
    }

    public function render($request, Throwable $e)
    {
        if ($request->expectsJson()) {
            return $this->renderJsonResponse($e);
        }

        return parent::render($request, $e);
    }

    private function renderJsonResponse(Throwable $e): \Illuminate\Http\JsonResponse
    {
        $statusCode = $this->isHttpException($e) ? $e->getStatusCode() : 500;

        $response = [
            'success' => false,
            'message' => $statusCode === 500 ? 'Internal Server Error' : $e->getMessage(),
        ];

        if (config('app.debug')) {
            $response['debug'] = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ];
        }

        return response()->json($response, $statusCode);
    }
}
