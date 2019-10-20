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
            //el metodo retry va a intentar reenviar el email en caso de falla
            //el primer parametro es las veces que queremos que reeintente
            //luego recibe la accion a realizar,le pasarmeos un closure con el usuario para poder usarlo en el interior
            //como tercer parametro son los milisegundos entre un intento y otro
           retry(5,function() use ($user){
               Mail::to($user->email)->send(new UserCreated($user));
            },100);
        });
        //solo necesitamos que se envie el email de actualizacion de email, solo si SE ACTUALLZO EL EMAIL, SI NO NO TIENE SENTIDO ENVIARLO
        User::updated(function($user){
            //si el email fue modificado
            //devuelve true isDirty
            if($user->isDirty('email')){
                retry(5,function()use($user){
                    Mail::to($user->email)->send(new UserMailChanged($user));
                },100);
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
