<?php

namespace App;

use App\Transaction;

//como un comprador es un usuario, extendemos de user
class Buyer extends User
{
    //

    //un comprador puede hacer muchas transacciones
    public function transactions(){
    	return $this->hasMany(Transaction::class);
    	
    }
}
