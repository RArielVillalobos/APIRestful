<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //tenemos que traer solo los usuarios que tengan transaciones, esto los convierte en compradores
        //has recibe una relacion que tenga el modelo
        $compradores=Buyer::has('transactions')->get();
    
        return $this->showAll($compradores);

    }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //para usar el implicit binding en buye debemos primero definir un scope
    //si no traera todos los usuarios y no los que sean compradores(tienen que tener transacciones)
    public function show(Buyer $buyer)
    {
       // $buyer=Buyer::has('transactions')->findOrFail($buyer);
        return $this->showOne($buyer);

    }

  
}
