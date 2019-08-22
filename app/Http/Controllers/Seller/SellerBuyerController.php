<?php

namespace App\Http\Controllers\Seller;

use App\Category;
use App\Http\Controllers\ApiController;
use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //obtenemos los compradores de un determinado vendedor
    public function index(Seller $seller)
    {
        //accedemos a los productos del vendedor
        $buyers=$seller->products()
            //solamente los productos que tengan transacciones
            ->whereHas('transactions')
            ->with('transactions.buyer')
            ->get()
            //obtenemos solo las transacciones
            ->pluck('transactions')
            //las unimos
            ->collapse()
            //el comprador de cada una de esas transacciones
            ->pluck('buyer')
            ->unique('id')
            ->values();

        return $this->showAll($buyers);


    }

}
