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

/*CATEGORIES*/
Route::resource('categories','Category\CategoryController',['except'=>['create','edit']]);

/*Products*/
Route::resource('products','Product\ProductController',['only'=>['index','show']]);

/*Transactions*/
Route::resource('transactions','Transaction\TransactionController',['only'=>['index','show']]);

/*Seller*/
Route::resource('sellers','Seller\SellerController',['only'=>['index','show']]);

/*Users*/
/*vamos a permitir todas las operaciones excepto create y edit*/
Route::resource('users','User\UserController',['except'=>['create','edit']]);
