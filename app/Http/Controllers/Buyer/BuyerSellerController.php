<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerSellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        //obtener vendedores de un comprador en especifico
        //transactions() eager loading
        //queremos obtener el vendedor de cada producto
        //puede pasar que diferentes transacciones vendan diferentes productos pero del mismo vendedor, con unique resolvemos esto
        // si encuentra algun valor repetido y lo elimina de la coleccion, esto dejaria un elemento vacio en la coleccion,para ello usaremos values(), que reorganizara los indeces en el orden correcto y eliminara los vacios
        $sellers=$buyer->transactions()->with('product.seller')->get()->pluck('product.seller')->unique('id')->values();

        return $this->showAll($sellers);


    }


}
