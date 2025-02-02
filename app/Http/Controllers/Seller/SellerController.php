<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //tenemos que traer solo los usuarios que tengan productos, esto los convierte en vendedores
        //has recibe una relacion que tenga el modelo
        $vendedores=Seller::has('products')->get();

        return $this->showAll($vendedores);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller)
    {
        //
        //$vendedor=Seller::has('products')->findOrFail($id);
        return $this->showOne($seller);
    }




}
