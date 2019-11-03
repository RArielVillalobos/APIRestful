<?php

namespace App\Http\Middleware;

use Closure;

class TransformInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$transformer)
    {
        //vamos a transformar las entradas
        //hay que ser cuidadoso y solo transformar las entradas y no incluir los query params(los params que vienen en la url)
        $transformedInput=[];
        //vamos a recorrer los campos recibimos, unicamente en el cuerpo de la consulta y no como los parametros
        //esto lo hacemos a traves de $request->all (tiene lo relacionado con la peticion y no con lo que viene en la url)

        foreach ($request->all() as $input=>$value){
            $transformedInput[$transformer::originalAttribute($input)]=$value;

        }

        //remplazamos la peticion original
        $request->replace($transformedInput);

        return $next($request);
    }
}
