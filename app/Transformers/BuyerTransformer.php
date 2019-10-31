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
            'fechaEliminacion'=>isset($buyer->delated_at) ? (string) $buyer->deleted_at : null
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
