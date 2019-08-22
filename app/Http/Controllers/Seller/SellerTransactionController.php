<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //transacciones de un vendedor
    public function index(Seller $seller)
    {
        //
        $transactions=$seller->products()
            //obtenemos si al menos hay una transaccion
            ->whereHas('transactions')
            //la obtenemos
            ->with('transactions')
            ->get()
            //dejamos solo la transaccion
            ->pluck('transactions')
            //unimos las listas
            ->collapse();

        return $this->showAll($transactions);
    }


}
