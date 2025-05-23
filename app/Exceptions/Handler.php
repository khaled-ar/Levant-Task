<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->reportable(function (Throwable $e) {
            // parent::report($e);
        });

    }

    public function render($request, Exception|Throwable $e)
    {
        /* Here we can create a single exception file.*/

        if ($e instanceof ThrottleRequestsException) {
            return response()->json([
                'message' => 'Too Many Attempts, Retry After One Minute.',
            ], 429);
        }


        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'message' => 'Record Not Found.',
            ], 404);
        }

        if ($e instanceof AuthorizationException) {
            return response()->json([
                'message' => 'This action is unauthorized.',
            ], 403);
        }

        if ($e instanceof UniqueConstraintViolationException) {
            return response()->json([
                'message' => 'This record already exists.',
            ]);
        }

        if ($e instanceof QueryException) {
            return response()->json([
                'message' => 'Unknown sql error.',
            ]);
        }

        if ($e instanceof ValidationException) {
            $res_errors = collect($e->errors())
                ->flatten()
                ->values()
                ->all();

            return response()->json([
                'errors' => $res_errors,
            ], 422);
        }
        return parent::render($request, $e);
    }
}
