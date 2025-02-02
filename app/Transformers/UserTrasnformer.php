<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTrasnformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            //
            'identificador'=> (int) $user->id,
            'nombre'=> (string) $user->name,
            'correo'=> (string) $user->email,
            'esVerificado'=> (int) $user->verified,
                             //no es un entero o string, es un boolean, nos tentariamos a usar (boolean) pero
                            //tenemos que recordar que cuando viene directo de la base viene como un string "boolean"
                            //retornaremos el valor de verdad d esta comparacion
            'esAdministrador'=> ($user->admin==='true'),
            'fechaCreacion'=>(string)$user->created_at,
            'fechaActualizacion'=>(string)$user->updated_at,
            'fechaEliminacion'=>isset($user->deleted_at) ? (string) $user->deleted_at : null,
            'links'=>[
                [
                    'rel'=>'self',
                    'href'=>route('users.show',$user->id),

                ],

            ]


        ];
    }

    public static function originalAttribute($index){
        $atributes=[
            //
            'identificador'=> 'id',
            'nombre'=> 'name',
            'correo'=> 'email',
            'esVerificado'=> 'verified',
            'esAdministrador'=> 'admin',
            'fechaCreacion'=>'created_at',
            'fechaActualizacion'=>'updated_at',
            'fechaEliminacion'=>'deleted_at'


        ];

        return isset($atributes[$index]) ?$atributes[$index]:null;


    }
}
