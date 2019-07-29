<?php

namespace App;


use App\Product;


class Seller extends User
{
    //

	//un vendedor puede tener muchos productos
    public function products(){
    	return $this->hasMany(Product::class);
    }
}
