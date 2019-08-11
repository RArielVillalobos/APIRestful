<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SellerController extends Controller
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

        return response()->json(['data'=>$vendedores],200);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $vendedor=Seller::has('products')->findOrFail($id);
        return response()->json(['data'=>$vendedor],200);
    }




}
