<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable=['name,description'];

    //una categoria puede pertenecer a muchos productos
    public function products(){
    	return $this->belongsToMany(Product::class);
    }
}
