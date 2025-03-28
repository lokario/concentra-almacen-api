<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler {
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register() {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception) {
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'message' => 'Metodo HTTP no permitido.',
            ], 405);
        }

        if ($exception instanceof AuthorizationException) {
            return response()->json([
                'message' => 'No autorizado.',
            ], 403);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'message' => 'Recurso no encontrado.',
            ], 404);
        }

        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'message' => 'Registro no encontrado.',
            ], 404);
        }

        if ($exception instanceof QueryException && $exception->getCode() === '23000') {
            if (str_contains($exception->getMessage(), 'FOREIGN KEY constraint failed')) {
                return response()->json([
                    'message' => 'Este recurso no se puede eliminar porque tiene elementos relacionados.',
                ], 409);
            }
        }

        return parent::render($request, $exception);
    }
}
