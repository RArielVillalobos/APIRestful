<?php

namespace App\Transformers;

use App\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            //
            'identificador'=> (int) $category->id,
            'titulo'=> (int) $category->name,
            'detalles'=> (int) $category->description,
            'fechaCreacion'=>(string)$category->created_at,
            'fechaActualizacion'=>(string)$category->updated_at,
            'fechaEliminacion'=>isset($category->delated_at) ? (string) $category->deleted_at : null,
            'links'=>[
                [
                    'rel'=>'self',
                    'href'=>route('categories.show',$category->id),

                ],
                //compradores de la categoria
                [
                    'rel'=>'category.buyers',
                    'href'=>route('categories.buyers.index',$category->id)
                ],
                [
                    'rel'=>'category.products',
                    'href'=>route('categories.products.index',$category->id)
                ],
                [
                    'rel'=>'category.sellers',
                    'href'=>route('categories.sellers.index',$category->id)
                ],
                [
                    'rel'=>'category.transactions',
                    'href'=>route('categories.transactions.index',$category->id)
                ]
            ]


        ];
    }

    public static function originalAttribute($index){
        $atributes=[
            //
            'identificador'=> 'id',
            'titulo'=> 'name',
            'detalles'=> 'description',
            'fechaCreacion'=>'created_at',
            'fechaActualizacion'=>'updated_at',
            'fechaEliminacion'=>'deleted_at'
        ];

        return isset($atributes[$index]) ?$atributes[$index]:null;
    }
}
