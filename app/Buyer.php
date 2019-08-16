<?php

namespace App;

use App\Scopes\BuyerScope;
use App\User;
use App\Transaction;

//como un comprador es un usuario, extendemos de user
class Buyer extends User
{
    //cada vez que vaya a ejecutar una consulta utilice este global scope en ella
    //es utilizado para construir e inicializar el modelo
    protected static function boot(){
        //primero se llama al padre
        parent::boot();
        //usamos el  operador static ya que estamos dentro de un metodo static, y para hacer referencia a la misma clase se usa static
        static::addGlobalScope(new BuyerScope);

    }

    //un comprador puede hacer muchas transacciones
    public function transactions(){
    	return $this->hasMany(Transaction::class);
    	
    }
}
