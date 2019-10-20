<?php

namespace App\Http\Middleware;

use Closure;

class SignatureMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    /*ESTE MIDDLEWARE AGREGARA UNA CABEZERA A LA RESPUESTA
     POR LO TANTO PRIMERO DEBEMOS CONSTRUIR LA RESPUESTA Y LUEGO ACTUAR SOBRE LA RESPUESTA
    */
    //cuando se agregan cabezera personalizadas a las respuestas o peticiones que no son parte de http, como buena practica debemos poner una X
    //como es un middleware que actua sobre la respuesta se conoce como AFTER-MIDDLEWARE(SE EJECUTA DESPUES DE HABER CONSTUIDO LA RESPUESTA)
    //si quiseramos hacer un before middleware, tendriamos que haber ejecutado todo antes d haber llamado al metodo next(antes d q se construyera la respuesta)
    public function handle($request, Closure $next,$header='X-Name')
    {
        $response=$next($request);
        //el valor sera el nombre de la app
        $response->headers->set($header,config('app.name'));
        return $response;
    }
}
