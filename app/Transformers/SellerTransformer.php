<?php

namespace App\Transformers;

use App\Seller;
use League\Fractal\TransformerAbstract;

class SellerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Seller $seller)
    {
        return [
            //
            'identificador'=> (int) $seller->id,
            'nombre'=> (string) $seller->name,
            'correo'=> (string) $seller->email,
            'esVerificado'=> (int) $seller->verified,
            'fechaCreacion'=>(string)$seller->created_at,
            'fechaActualizacion'=>(string)$seller->updated_at,
            'fechaEliminaxion'=>isset($seller->delated_at) ? (string) $seller->deleted_at : null,
            'links'=>[
                [
                    'rel'=>'self',
                    'href'=>route('sellers.show',$seller->id),

                ],
                [
                    'rel'=>'buyers.categories',
                    'href'=>route('buyers.categories.index',$seller->id),

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
