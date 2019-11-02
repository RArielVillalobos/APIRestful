<?php

namespace App\Transformers;

use App\Buyer;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Buyer $buyer)
    {
        return [
            //
            'identificador'=> (int) $buyer->id,
            'nombre'=> (string) $buyer->name,
            'correo'=> (string) $buyer->email,
            'esVerificado'=> (int) $buyer->verified,
            'fechaCreacion'=>(string)$buyer->created_at,
            'fechaActualizacion'=>(string)$buyer->updated_at,
            'fechaEliminacion'=>isset($buyer->delated_at) ? (string) $buyer->deleted_at : null,
            'links'=>[
                [
                    'rel'=>'self',
                    'href'=>route('buyers.show',$buyer->id),

                ],
                [
                    'rel'=>'buyers.categories',
                    'href'=>route('buyers.categories.index',$buyer->id),

                ],
                [
                    'rel'=>'buyers.products.index',
                    'href'=>route('buyers.products.index',$buyer->id),

                ],
                [
                    'rel'=>'buyers.sellers.index',
                    'href'=>route('buyers.sellers.index',$buyer->id),

                ],
                [
                    'rel' => 'buyer.transactions',
                    'href' => route('buyers.transactions.index', $buyer->id),
                ],
                [
                    'rel'=>'users.show',
                    'href'=>route('users.show',$buyer->id),

                ],

            ]
        ];
    }

    public static function originalAttribute($index){
        $atributes=[
            //
            'identificador'=> 'id',
            'nombre'=>  'name',
            'correo'=>  'email',
            'esVerificado'=> 'verified',
            'fechaCreacion'=>'created_at',
            'fechaActualizacion'=>'updated_at',
            'fechaEliminacion'=>'deleted_at'
        ];

        return isset($atributes[$index]) ?$atributes[$index]:null;
    }
}
