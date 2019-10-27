<?php

namespace App;

use App\Buyer;
use App\Product;
use App\Transformers\TransactionTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    //
    use SoftDeletes;
    //indicaremos que uno de los atributos debera ser tratado como fecha
    protected $dates=['deleted_at'];
    protected $fillable=[
    	'quantity',
    	'buyer_id',
    	'product_id'
    ];
    //por medio de ::class accedemos al nombre completo de la clase junto con el nombre de espacio
    public $transformer=TransactionTransformer::class;

    //una transaccion pertenece a un producto
    public function product(){
    	return $this->belongsTo(Product::class);
    }

    //una transaccion pertenece a un comprador
    public function buyer(){
    	return $this->belongsTo(Buyer::class);
    }
}
