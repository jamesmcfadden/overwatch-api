<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        \Rollbar::report_exception($e);

        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        return $this->renderJson($request, $e);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function renderJson($request, Exception $e)
    {
        $response = parent::render($request, $e);
        $status = $response->getStatusCode();

        switch (true) {
            case $e instanceof ModelNotFoundException:
                $title = 'Resource not found';
                $detail = 'The requested resource could not be found';
                break;
            case $e instanceof NotFoundHttpException:
                $title = 'Route not found';
                $detail = 'The requested route could not be resolved';
                break;
            case $e instanceof MethodNotAllowedHttpException:
                $title = 'Method not allowed';
                $detail = 'The method given is not allowed';
                break;
            case $e instanceof HttpResponseException:
                $title = 'HTTP response exception';
                $detail = 'There was an application exception while fulfilling the request';
                break;
            default:
                $title = 'Application exception';
                $detail = 'There was an application exception while fulfilling the request';
                break;
        }

        $meta = [];
        if (config('app.debug')) {
            $meta['exception'] = [
                'type' => get_class($e),
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString(),
            ];
        }
        if ($response instanceof JsonResponse) {
            $meta['data'] = $response->getData();
        }
        $exceptionData = [
            'status' => $status,
            'title' => $title,
            'detail' => $detail,
            'code' => null,
            'meta' => $meta,
        ];

        return new JsonResponse([
            'error' => $exceptionData,
        ], $status);
    }
}
