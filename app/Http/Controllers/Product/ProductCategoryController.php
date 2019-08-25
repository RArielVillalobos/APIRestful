<?php

namespace App\Http\Controllers\Product;

use App\Category;
use App\Http\Controllers\ApiController;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //muestra las categorias de un producto
    public function index(Product $product)
    {
        //
        $categories=$product->categories;

        return $this->showAll($categories);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product,Category $category)
    {
        //interactuar con la relacion de los modeos
        //tenemos 3 opciones
        //sync,attach,syncWithoutDetaching
        $product->categories()->syncWithoutDetaching([$category->id]);
        return $this->showAll($product->categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product,Category $category)
    {
        //
        if(!$product->categories()->find($category->id)){
            return $this->errorResponse('la categoria especificada no es una categoria de este producto',404);
        }

        //en caso de que exista eliminamos la categoria del producto
        $product->categories()->detach([$category->id]);
        return $this->showAll($product->categories);



    }

}
