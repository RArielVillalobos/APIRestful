<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Seller;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        //
        $products=$seller->products;
        return $this->showAll($products);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,User $seller)
    {
        //
        $rules=[
            'name'=>'required',
            'description'=>'required',
            'quantity'=>'required|integer|min:1',
            'image'=>'required|image'
        ];

        $this->validate($request,$rules);
        $data=$request->all();
        $data['status']=Product::PRODUCTO_NO_DISPONIBLE;
        $data['image']='1.jpg';
        $data['seller_id']=$seller->id;
        $product=Product::create($data);
        return $this->showOne($product,201);



    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller,Product $product)
    {
        //
        $rules=[
            'quantity'=>'integer|min:1',
            //uno de los valores definidos
            'status'=>'in:'.Product::PRODUCTO_DISPONIBLE.','. Product::PRODUCTO_NO_DISPONIBLE,
            'image'=>'image',

        ];
        $this->validate($request,$rules);
        //si el id del vendedor que enviamos en la peticion es igual al vendedor del producto
       $this->verificarVendedor($seller,$product);
        $product->fill($request->intersect([
            'name','description','quantity'
        ]));
        //se puede cambiar el estado si el producto tiene al menos asociada una categoria
        if($request->has('status')){
            $product->status=$request->status;
            if($product->estaDisponible() && $product->categories()->count()==0){
                return $this->errorResponse('Un producto activo debe tener al menos una categoria',409);

            }
        }
        //si no se modificio la instancia
        if($product->isClean()){
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar',422);
        }

        $product->save();

        return $this->showOne($product);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller,Product $product)
    {
        //
        $this->verificarVendedor($seller,$product);
        $product->delete();

        return $this->showOne($product);
    }

    public function verificarVendedor(Seller $seller,Product $product){
        //si el id del vendedor que enviamos en la peticion es igual al vendedor del producto
        if($seller->id !=$product->seller_id){
            //disparamos una excepcion
            throw new HttpException(422,'El vendedor especificado real no es el vendedor del producto');

        }
    }
}
