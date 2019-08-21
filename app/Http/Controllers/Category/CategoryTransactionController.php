<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //transacciones de una categoria en especifico
    public function index(Category $category)
    {
        //
        $transactions=$category->products()
            //productos que al menos tengan asociadas una transaccion
            ->whereHas('transactions')
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->unique('id')
            ->values();

        return $this->showAll($transactions);

    }

}
