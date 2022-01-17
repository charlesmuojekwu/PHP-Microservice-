<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponser;
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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        /// for http exception errors
        if($exception instanceof HttpException) {

            $code = $exception->getStatusCode();
            $message = Response::$statusTexts[$code];

            return $this->errorResponse($message, $code);
        }

        /// model not found exception when using findorfail in model
        if($exception instanceof ModelNotFoundException ) {
            $model = strtolower(class_basename($exception->getModel()));

            return $this->errorResponse("Instance of {$model} with the given Id does not exist",Response::HTTP_NOT_FOUND);
        }


        /// authorization  error exception

        if($exception instanceof AuthorizationException) {
            return $this->errorResponse($exception->getMessage(),Response::HTTP_FORBIDDEN);
        }


        ///  authentication error exception

        if($exception instanceof AuthenticationException) {
            return $this->errorResponse($exception->getMessage(),Response::HTTP_UNAUTHORIZED);
        }


        /// validation error exception
        if($exception instanceof ValidationException){
            $errors = $exception->validator->errors()->getMessages();

            return $this->errorResponse($errors,Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        /// other error that are not handled

        /// for development it is set to true ... this show all debug errors
        if(env('APP_DEBUG',false)){
            return parent::render($request, $exception);
        }


        /// other error that are not handled
        return $this->errorResponse('Unexpected error.try later',Response::HTTP_INTERNAL_SERVER_ERROR);


    }
}
