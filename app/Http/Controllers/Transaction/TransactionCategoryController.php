<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //obtener la lista de categorias respectivas a una transaccion especifica
    public function index(Transaction $transaction)
    {
        //
        $categories=$transaction->product->categories;

        return $this->showAll($categories);

    }


}
