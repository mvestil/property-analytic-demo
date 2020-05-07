<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Throwable $exception
     * @return void
     *
     * @throws Throwable
     */
    public function report(Throwable $exception)
    {
        $this->reportWithSeverity($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable               $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($handled = $this->handleToBeRenderedException($exception)) {
            return $handled;
        }

        return parent::render($request, $exception);
    }

    /**
     * Handle specific exceptions thrown for rendering
     *
     * @param Throwable $exception
     * @return \Illuminate\Http\JsonResponse|void
     */
    protected function handleToBeRenderedException(Throwable $exception)
    {
        // We can use Renderable exceptions as well (https://laravel.com/docs/7.x/errors#renderable-exceptions)
        // We'll settle this for now for demo purposes
        if ($exception instanceof ValidationException) {
            return response()->json(['error' => $exception->getMessage()], 400);
        } elseif ($exception instanceof NotFoundHttpException) {
            return response()->json(['error' => 'Missing route'], 404);
        } elseif ($exception instanceof ModelNotFoundException) {
            return response()->json(['error' => 'Resource not found'], 404);
        }
    }

    /**
     * Overriding parent::report() but supports for logging different types of severity
     *
     * @param Throwable $e
     * @throws Throwable
     */
    protected function reportWithSeverity(Throwable $e): void
    {
        if ($this->shouldntReport($e)) {
            return;
        }

        if (is_callable($reportCallable = [$e, 'report'])) {
            $this->container->call($reportCallable);

            return;
        }

        $this->logWithSeverity($e);
    }

    /**
     * Log with severity depends on the exception
     *
     * @param Throwable $e
     * @throws \Exception
     */
    protected function logWithSeverity(Throwable $e): void
    {
        $logData = [
            $message = $e->getMessage(),
            $context = array_merge(
                $this->exceptionContext($e),
                $this->context(),
                ['exception' => $e]
            )
        ];

        $logger = $this->getLogger();

        if (isset($e->severity) && method_exists($logger, $e->severity)) {
            $logger->{$e->severity}(...$logData);
        } else {
            $logger->error(...$logData);
        }
    }

    /**
     * Get logger instance
     *
     * @return LoggerInterface
     * @throws \Exception
     */
    protected function getLogger()
    {
        try {
            return $this->container->make(LoggerInterface::class);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
