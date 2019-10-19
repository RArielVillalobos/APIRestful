<?php

namespace App\Providers;

use App\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        //recibe un clouse con la instancia que se esta actualizando
        //si la cantidad es 0 y el producto aun es disponible se debe actualizar a no disponible
        Product::updated(function ($product){
            if($product->quantity==0 && $product->estaDisponible()){
                $product->status=Product::PRODUCTO_NO_DISPONIBLE;
                $product->save();
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
