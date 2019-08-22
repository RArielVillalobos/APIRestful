<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    //
    use SoftDeletes;

    //indicaremos que uno de los atributos debera ser tratado como fecha
    protected $dates=['deleted_at'];
    protected $fillable=['name','description'];

    //ocultar el atributo pivot(de la relacion n a n con producto)
    protected $hidden= ['pivot'];

    //una categoria puede pertenecer a muchos productos
    public function products(){
    	return $this->belongsToMany(Product::class);
    }
}
