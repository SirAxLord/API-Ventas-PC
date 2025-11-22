<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        // Podemos agregar reportables si se requiere.
    }

    public function render($request, Throwable $e)
    {
        // Si no es petición API, usar comportamiento normal.
        if (! $request->is('api/*') && ! $request->is('v1/*') && ! $request->wantsJson()) {
            return parent::render($request, $e);
        }

        // Validation
        if ($e instanceof ValidationException) {
            return $this->errorResponse(
                'Datos inválidos',
                422,
                $e->errors()
            );
        }

        // Model not found
        if ($e instanceof ModelNotFoundException) {
            return $this->errorResponse('Recurso no encontrado', 404);
        }

        // Auth
        if ($e instanceof AuthenticationException) {
            return $this->errorResponse('No autenticado', 401);
        }

        // HTTP exceptions (403, 404 custom, etc.)
        if ($e instanceof HttpExceptionInterface) {
            return $this->errorResponse(
                $e->getMessage() ?: 'Error HTTP',
                $e->getStatusCode()
            );
        }

        // Fallback
        return $this->errorResponse('Error interno del servidor', 500);
    }

    private function errorResponse(string $message, int $status, array $errors = null)
    {
        $payload = [
            'error' => [
                'message' => $message,
                'status' => $status,
            ],
            'meta' => [
                'version' => 'v1',
                'timestamp' => now()->toISOString(),
            ],
        ];
        if ($errors) {
            $payload['error']['details'] = $errors;
        }
        return response()->json($payload, $status);
    }
}
