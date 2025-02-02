<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*BUYERS*/
//el primer parametro es el nombre del recurso(ruta), normalmente en plural, el 2do es el controlador(nuestro caso seria primero la carpeta)
//como nosotros no vamos a usar la ruta create(mostrar un formulario)
//solo habilitaremos la ruta para el index y show en este caso
Route::resource('buyers','Buyer\BuyerController',['only'=>['index','show']]);
Route::resource('buyers.sellers','Buyer\BuyerSellerController',['only'=>'index']);
Route::resource('buyers.categories','Buyer\BuyerCategoryController',['only'=>'index']);
Route::resource('buyers.products','Buyer\BuyerProductController',['only'=>'index']);
Route::resource('buyers.transactions','Buyer\BuyerTransactionController',['only'=>'index']);


/*CATEGORIES*/
Route::resource('categories','Category\CategoryController',['except'=>['create','edit']]);
Route::resource('categories.sellers','Category\CategorySellerController',['only'=>'index']);
Route::resource('categories.transactions','Category\CategoryTransactionController',['only'=>'index']);
Route::resource('categories.buyers','Category\CategoryBuyerController',['only'=>'index']);
Route::resource('categories.products','Category\CategoryProductController',['only'=>'index']);


/*Products*/
Route::resource('products','Product\ProductController',['only'=>['index','show']]);
Route::resource('products.buyers','Product\ProductBuyerController',['only'=>'index']);
Route::resource('products.categories','Product\ProductCategoryController',['only'=>['index','update','destroy']]);
Route::resource('products.transactions','Product\ProductTransactionController',['only'=>'index']);
Route::resource('products.buyers.transactions','Product\ProductBuyerTransactionController',['only'=>'store']);


/*Transactions*/
Route::resource('transactions','Transaction\TransactionController',['only'=>['index','show']]);
Route::resource('transactions.categories','Transaction\TransactionCategoryController',['only'=>'index']);
Route::resource('transactions.sellers','Transaction\TransactionSellerController',['only'=>'index']);


/*Seller*/
Route::resource('sellers','Seller\SellerController',['only'=>['index','show']]);
Route::resource('sellers.transactions','Seller\SellerTransactionController',['only'=>'index']);
Route::resource('sellers.categories','Seller\SellerCategoryController',['only'=>'index']);
Route::resource('sellers.buyers','Seller\SellerBuyerController',['only'=>'index']);
Route::resource('sellers.products','Seller\SellerProductController',['except'=>'show','edit','create']);

/*Users*/
/*vamos a permitir todas las operaciones excepto create y edit*/
Route::resource('users','User\UserController',['except'=>['create','edit']]);
Route::get('users/verify/{token}','User\UserController@verify')->name('users.verify');
Route::get('users/{user}/resend','User\UserController@resend')->name('users.resend');
