<?php

use App\User;
use App\Product;
use App\Category;
use App\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//deshabilitar verificacion llave foranea
    	DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // $this->call(UsersTableSeeder::class);
        //eliminaremos todos los datos que hayan en las tabla de cada modelo
        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        //tabla pivote
        DB::table('category_product')->truncate();

        $cantidadUsuarios=200;
        $cantidadCategorias=30;
        $cantidadProductos=1000;
        $cantidadTransacciones=1000;
        factory(User::class,$cantidadUsuarios)->create();
        factory(Category::class,$cantidadCategorias)->create();
        //each por cada instancia creada
        factory(Product::class,$cantidadTransacciones)->create()->each(function($producto){
        	//obtengo categorias(hasta 5) al azar, solo su id a traves de pluck
        	$categorias=Category::all()->random(mt_rand(1,5))->pluck('id');
        	//el metodo attach recibe un arreglo de categorias
        	//adjuntando las categorias al producto	
        	$producto->categories()->attach($categorias);
        });

        factory(Transaction::class,$cantidadTransacciones)->create();

    }
}
