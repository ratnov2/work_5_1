<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

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
    public function register()
    {
        $this->reportable(function (\Throwable $e) {
            Log::error('[' . $e->getCode() . ']' . ' ' . get_class($e) . ' "' . $e->getMessage() . '" on line ' . $e->getLine() . ' of file ' . $e->getFile());
            return false;
        });
    }

    public function render($request, \Throwable $e)
    {
        if ($e instanceof ThrottleRequestsException) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'Слишком много запросов. Пожалуйста, подождите...'
                ]);
            }
        }

        if ($e instanceof ValidationException) {
            if ($request->wantsJson()) {
                $msg = collect($e->errors())->map(fn($error) => (string) $error[0] . "\r\n")->implode('\r\n');
                return response()->json([
                    'status' => 'error',
                    'msg' => $msg
                ]);
            }
        }

        return parent::render($request, $e);
    }
}
