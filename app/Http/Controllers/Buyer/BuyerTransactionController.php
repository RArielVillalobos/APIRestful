<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //transacciones de un comprador
    public function index(Buyer $buyer)
    {
        //
        $transactions=$buyer->transactions;

        return $this->showAll($transactions);


    }


}
