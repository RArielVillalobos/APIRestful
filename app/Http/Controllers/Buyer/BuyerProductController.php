<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        //en transactions()->obtenemos un query builder que nos permite agregar diferentes restricciones a las consultas como where ,etc
        //obtendremos una lista de transacciones y cada una de ellas con su respectivo producto
        //como solo  queremos obtener el producto de cada transaccion, lo hacemos con el metodo pluck

        $products=$buyer->transactions()->with('product')->get()->pluck('product');
        return $this->showAll($products);

    }

}
