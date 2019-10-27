<?php

namespace App;


use App\Product;
use App\Scopes\SellerScope;
use App\Transformers\UserTrasnformer;


class Seller extends User
{
    //por medio de ::class accedemos al nombre completo de la clase junto con el nombre de espacio
    public $transformer=UserTrasnformer::class;
    //
    //cada vez que vaya a ejecutar una consulta utilice este global scope en ella
    //es utilizado para construir e inicializar el modelo
    protected static function boot(){
        //primero se llama al padre
        parent::boot();
        //usamos el  operador static ya que estamos dentro de un metodo static, y para hacer referencia a la misma clase se usa static
        static::addGlobalScope(new SellerScope());

    }

	//un vendedor puede tener muchos productos
    public function products(){
    	return $this->hasMany(Product::class);
    }
}
