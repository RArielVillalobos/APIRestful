<?php

namespace App\Transformers;

use App\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            //
            'identificador'=> (int) $product->id,
            'titulo'=>(string)$product->name,
            'detalles'=>(string) $product->description,
            'disponibles'=>(string) $product->quantity,
            'estado'=>(string)$product->status,
            'imagen'=>url("img{$product->image}"),
            'vendedor'=>(int)$product->seller_id,
            'fechaCreacion'=>(string)$product->created_at,
            'fechaActualizacion'=>(string)$product->updated_at,
            'fechaEliminacion'=>isset($product->delated_at) ? (string) $product->deleted_at : null,
            'links'=>[
                [
                    'rel'=>'self',
                    'href'=>route('products.show',$product->id),

                ],
                //compradores de la categoria
                [
                    'rel'=>'product.buyers',
                    'href'=>route('products.buyers.index',$product->id)
                ],
                [
                    'rel'=>'product.categories',
                    'href'=>route('products.categories.index',$product->id)
                ],
                [
                    'rel'=>'product.transactions',
                    'href'=>route('products.transactions.index',$product->id)
                ],
                [
                    'rel'=>'seller',
                    'href'=>route('sellers.show',$product->seller_id)
                ]
            ]


        ];
    }

    public static function originalAttribute($index){
        $atributes=[
            //
            'identificador'=> 'id',
            'titulo'=>'name',
            'detalles'=> 'description',
            'disponibles'=> 'quantity',
            'estado'=>'status',
            'imagen'=>'image',
            'vendedor'=>'seller_id',
            'fechaCreacion'=>'created_at',
            'fechaActualizacion'=>'updated_at',
            'fechaEliminacion'=>'deleted_at'
        ];

        return isset($atributes[$index]) ?$atributes[$index]:null;
    }
}
