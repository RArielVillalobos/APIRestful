<?php

use App\User;
use App\Seller;
use App\Product;
use App\Category;
use App\Transaction;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'verified'=>$faker->randomElement([User::USUARIO_VERIFICADO,USER::USUARIO_NO_VERIFICADO]),
        'verification_token'=>$verificado==User::USUARIO_VERIFICADO ?null : User::generarVerificationToken(),
        'admin'=>$faker->randomElement([User::USUARIO_ADMINISTRADOR,USER::USUARIO_REGULAR])
    ];
});

$factory->define(Category::class, function (Faker\Generator $faker) {
    

    return [
        'name' => $faker->word,
        //una sola palabra
       	'description'=>$faker->paragraph(1)
    ];
});

$factory->define(Product::class, function (Faker\Generator $faker) {
    

    return [
        'name' => $faker->word,
        //una sola palabra
       	'description'=>$faker->paragraph(1),
       	//numero entre 1 y 10
       	'quantity'=>$faker->numberBetween(1,10),
       	'status'=>$faker->randomElement(Product::PRODUCTO_DISPONIBL,Product::PRODUCTO_NO_DISPONIBLE),
       	'image'=>$faker->randomElement(['1.jpg','2.jpg','3.jpg']),
       	//obtendremos un user aleatorio
       	'seller_id'=>User::all()->random()->id
    ];
});

$factory->define(Transaction::class, function (Faker\Generator $faker) {
	//obtenemos una lista de los vendedores y obtenemos uno aleatorio
	//como no tenemos el modelo seler como tabla, sino que seller hereda de usuario, si un usuario tiene productos significa que es un vendedor
	//el metodo randim obtiene uno
	$vendedor=Seller::has('products')->get()->random();
	//obtenemos un comprador excepto  el vendeor
	$comprador=User::all()->except($vendedor->id)->random();

    

    return [
        'name' => $faker->word,
       	'quantity'=>$faker->numberBetween(1,3),
       	'buyer_id'=>$comprador->id,
       	'product_id'=>$vendedor->products->random()->id,
    ];
});
