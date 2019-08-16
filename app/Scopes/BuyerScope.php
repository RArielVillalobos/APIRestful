<?php
/**
 * Created by PhpStorm.
 * User: ariel
 * Date: 16/ago/2019
 * Time: 19:39
 */

namespace App\Scopes;
//los scopes son clases normales de php
//deben implementar una interface llamada Scope
//como estamos implementando una interface estamos obligados a implementar una funcion llamada appy
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class BuyerScope implements Scope {
    //recibe como param el constructor de la consulta y el modelo
    //por medio de este global scope podemos utilizar la inyeccion implicida de dependencia ( implicit binding)
    public function apply(Builder $builder, Model $model)
    {
        // TODO: Implement apply() method.
        //solo se obtienen las instancias que tienen transacciones
        $builder->has('transactions');
    }


}
