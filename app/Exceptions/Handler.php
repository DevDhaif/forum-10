<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Inertia\Inertia;
use League\CommonMark\Environment\Environment;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return Inertia::render('NotFoundPage')
                ->toResponse($request)
                ->setStatusCode(404);
        }

        return parent::render($request, $exception);
    }

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
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
        $this->reportable(function (Throwable $e) {
            //
        });
        // if environment is testing, throw an exception


        // if (app()->environment() === 'testing') {
        //     $this->renderable(function (Throwable $e) {
        //         throw $e;
        //     });
        // }


    }

    // a function to  throw an exception if the environment is testing

}
