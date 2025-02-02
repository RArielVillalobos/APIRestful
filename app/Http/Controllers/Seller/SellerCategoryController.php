<?php

namespace App\Http\Controllers\Seller;

use App\Category;
use App\Http\Controllers\ApiController;
use App\Seller;
use Illuminate\Http\Request;

class SellerCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //lista de categorias de un determinado vendedor
    public function index(Seller $seller)
    {
        //
        $categories=$seller->products()
            ->with('categories')
            ->get()
            ->pluck('categories')
            ->collapse()
            ->unique('id')
            ->values();

        return $this->showAll($categories);
    }


}
