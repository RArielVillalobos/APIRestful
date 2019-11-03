<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Transaction;
use App\Transformers\TransactionTransformer;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{
    public function __construct()
    {
        //ejecutamos el metodo constructor del padre
        //si el constructor del padre realiza alguna tarea, seguira siendo ejecutada esa tarea
        parent::__construct();
        //registramos el middleware
        //recibe como param el nombre del transformador
        $this->middleware('transform.input:'.TransactionTransformer::class)->only(['store']);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /* recibira un producto y la instancia de un comprador que sera un usuario*/
    public function store(Request $request,Product $product, User $buyer)
    {
        $rules=[
            'quantity'=>'required|integer|min:1'
        ];
        $this->validate($request,$rules);
        //comprobar que el comprador y vendedor sean diferentes
        if($buyer->id==$product->seller_id){
            return $this->errorResponse('El comprador debe ser diferente del vendedor',409);

        }
        //si no es comprador verificado
        if(!$buyer->esVerificado()){
            return $this->errorResponse('El comprador debe ser verificado',409);

        }
        //si no es vendedor verificado
        if(!$product->seller->esVerificado()){
            return $this->errorResponse('El vendedor debe ser verificado',409);
        }
        //que el producto este disponible
        if(!$product->estaDisponible()){
            return $this->errorResponse('El producto para esta transaccion no esta disponible',409);
        }
        //que la cantidad pedida no sea superior a la disponible
        if($product->quantity<$request->quantity){
            return $this->errorResponse('El producto no tiene la cantidad disponible requerida para esta transaccion',409);
        }

        //ahora crearemos la transaccion
        //puede haber muchas transacciones de manera simultanea para varios productos
        //nuestra responsabilidad es asegurar la disponibilidad del producto para cada transaccion, de caso contrario retornar el error correspondiente
        //para asegurarnos que una transaccion se haga despues de la otra sin necesidad de alterar la manera de funcionar  d nuestro sistema
        //y ademas de lo que se hace en una transaccion se va a tomar en cuenta para la siguiente vamos a utilizar TRANSACCIONES DE LA BASE DE DATOS
        //SON OPERACIONES QUE SE REALIZAN COMPLETAS DE A UNA SOLA VEZ UNA X UNA

        //recibe una funcion,esta funcion debe hacer uso de las siguientes instancias, producto,comprador y la peticion

       return DB::transaction(function() use ($request,$product,$buyer){
            //lo primero que hara es reducir la cantidad disponible del producto
            $product->quantity-=$request->quantity;
            $product->save();

            $transaction=Transaction::create([
                'quantity'=>$request->quantity,
                'buyer_id'=>$buyer->id,
                'product_id'=>$product->id,
            ]);


           //como se genera una nueva transaccion el codigo es 201
           //return $this->showOne($transaction,201);
           return $this->showOne($transaction,201);


        });




    }

}
