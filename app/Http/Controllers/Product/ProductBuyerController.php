<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //compradores de un producto en especifico
    public function index(Product $product)
    {
        //
        $buyers=$product->transactions()
            ->with('buyer')
            ->get()
            ->pluck('buyer')
            ->unique()
            ->values();
        return $this->showAll($buyers);


    }


}
