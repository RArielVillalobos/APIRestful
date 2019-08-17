<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories=Category::all();
        return $this->showAll($categories);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules=[
            'name'=>'required',
            'description'=>'required'

        ];
        //si falla se duspara una excepcion
        $this->validate($request,$rules);
        $category=Category::create($request->all());
        return $this->showOne($category,201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
        return $this->showOne($category);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //el metodo fill recibe los valores que se van a actualizar
        //intersect solamente recibe por ej el nombre y descripcion, si se envia otro no sera tomado en cuenta
        $category->fill($request->intersect([
            'name',
            'description'
        ]));

        //si la categoria cambio algunos de sus valores con respecto a su instancia original
        //si la instancia no ha cambiado(isClean)
        if($category->isClean()){
            return $this->errorResponse('Debe especificar un valor diferente para actualizar',422);
        }
        //si la categoria se modifico
        $category->save();

        return $this->showOne($category);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
