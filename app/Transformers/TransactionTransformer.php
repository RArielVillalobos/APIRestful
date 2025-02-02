<?php

namespace App\Transformers;

use App\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
{

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            //
            'identificador'=> (int) $transaction->id,
            'cantidad'=>(int) $transaction->quantity,
            'comprador'=>(int) $transaction->buyer_id,
            'producto'=>(int) $transaction->product_id,
            'fechaCreacion'=>(string)$transaction->created_at,
            'fechaActualizacion'=>(string)$transaction->updated_at,
            'fechaEliminacion'=>isset($transaction->delated_at) ? (string) $transaction->deleted_at : null,
            'links'=>[
                [
                    'rel'=>'self',
                    'href'=>route('transactions.show',$transaction->id),

                ],

                [
                    'rel'=>'transaction.categories',
                    'href'=>route('transactions.categories.index',$transaction->id)
                ],
                //vendedor de esta transaccion
                [
                    'rel'=>'transaction.seller',
                    'href'=>route('transactions.sellers.index',$transaction->id)
                ],
                [
                    'rel'=>'buyer',
                    'href'=>route('buyers.show',$transaction->buyer_id)
                ],
                [
                    'rel'=>'product',
                    'href'=>route('products.show',$transaction->product_id)
                ]
            ]


        ];
    }

    public static function originalAttribute($index){
        $atributes=[
            //
            'identificador'=> 'id',
            'cantidad'=>'quantity',
            'comprador'=>'buyer_id',
            'producto'=>'product_id',
            'fechaCreacion'=>'created_at',
            'fechaActualizacion'=>'updated_at',
            'fechaEliminacion'=>'deleted_at'
        ];

        return isset($atributes[$index]) ?$atributes[$index]:null;
    }
}
