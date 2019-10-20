<?php

namespace App\Providers;

use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Mail;
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
        User::created(function($user){
            //el metodo send recibe como parametro el mailable a enviar , el mismo recibe como parametro el usuario al cual se le envia el email(lo definimos en el constructor)
           Mail::to($user->email)->send(new UserCreated($user));
        });
        //solo necesitamos que se envie el email de actualizacion de email, solo si SE ACTUALLZO EL EMAIL, SI NO NO TIENE SENTIDO ENVIARLO
        User::updated(function($user){
            //si el email fue modificado
            //devuelve true isDirty
            if($user->isDirty('email')){
                Mail::to($user->email)->send(new UserMailChanged($user));
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
