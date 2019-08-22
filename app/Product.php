<?php

namespace App;

use App\Seller;
use App\Category;
use App\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //
    use SoftDeletes;
    //indicaremos que uno de los atributos debera ser tratado como fecha
    protected $dates=['deleted_at'];
    const PRODUCTO_DISPONIBLE='disponible';
    const PRODUCTO_NO_DISPONIBLE='no disponible';

    //ocultar el atributo pivot(de la relacion n a n con categoria)
    protected $hidden= ['pivot'];
    protected $fillable=[
    	'name',
    	'description',
    	'quantity',
    	'status',
    	'image',
    	'seller_id'
    ];

    public function estaDisponible(){
    	//retorna true si el producto esta disponbile
    	return $this->status==self::PRODUCTO_DISPONIBLE;
    }

	//un producto pertenece a un vendedor
    public function seller(){
    	return $this->belongsTo(Seller::class);
    }
    //un producto puede pertenecer a muchas transacciones
    public function transactions(){
    	return $this->hasMany(Transaction::class);
    }

    //un producto puede tener muchas categorias
    public function categories(){
    	return $this->belongsToMany(Category::class);
    }



}
