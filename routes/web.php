<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\starterPageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', HomeController::class)->name('homes');

Route::get('home',HomeController::class)->name('home');




Route::get('product',ProductController::class)->name('product');
Route::get('product/{idCategory}',[ProductController::class, 'selectCategory'])->name('productByCategory');



Route::post('product/category/crear',[ProductController::class, 'addCategory'])->name('crear.category');


Route::post('product/crear',[ProductController::class, 'addProduct'])->name('crear.product');
Route::post('product/actualizar',[ProductController::class, 'updateProduct'])->name('actualizar.product');


Route::post('pedido/crear',[PedidoController::class,'create'])->name('crear.pedido');
Route::post('pedido/pagar',[PedidoController::class,'pagar'])->name('pagar.pedido');
Route::post('pedido/actualizar',[PedidoController::class,'update'])->name('actualizar.pedido');

Route::get('mesas',MesaController::class)->name('mesas');
Route::post('mesas/crear',[MesaController::class,'create'])->name('mesas.crear');

Auth::routes();

/*Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');*/
