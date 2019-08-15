<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if($exception instanceof ValidationException){
            $this->convertValidationExceptionToResponse($exception,$request);
        }
        if($exception instanceof ModelNotFoundException){
            //las excepciones de tipo ModelNotFoundException nos permite acceder al modelo que no se pudo encontrar
            //no es buena idea obtener la estructura de como esta organizado el modelo ej (App\User) asi que solamente obtendremos el nombre de la clase

            $model=strtolower(class_basename($exception->getModel()));
            return $this->errorResponse("no existe ninguna instancia  {$model} con el id especificado",404);
        }
        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }
        if($exception instanceof AuthorizationException){
            return $this->errorResponse('No posee permisos para ejecutar esta acción',403);
        }
        if($exception instanceof NotFoundHttpException){
            return $this->errorResponse('No se encontro la url especificada',404);
        }
        if($exception instanceof MethodNotAllowedHttpException){
            return $this->errorResponse('El metodo especificado en la peticion no es válido',405);
        }
        //controlaremos de forma general cualquier excepcion http
        //controlaremos cualquier otra excepcion
        if($exception instanceof HttpException){
            return $this->errorResponse($exception->getMessage(),$exception->getCode());
        }
        //quer pasaria si se quiere eliminar un registro que tiene relaciones a otra tabla error(1451)
        //lo bueno que podemos depurar la excepcion y ver mas a fondo dd($exception)
        if($exception instanceof QueryException){
            //dd($exception);
            $codigo=$exception->errorInfo[1];
            if($codigo==1451){
                //como es un conflicto, no se puede realizar la eliminacion debido a otros probleas dentro de sistema, el codigo retornado sera 409
                return $this->errorResponse('No se puede eliminar de forma permanente el recurso,esta relacionado con algun otro',409);
            }

        }
        //si  estamos en debug retornamos la respuesta html tipica
        if(config('app.debug')){
            return parent::render($request, $exception);
        }
        //si estamos en prod solo mostramos mensaje y el codigo
        return $this->errorResponse('Falla inesperada.Intente luego',500);




    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {

            return $this->errorResponse('No autenticado.', 401);

    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {

        $errors = $e->validator->errors()->getMessages();


        return $this->errorResponse($errors, 422);



    }
}
