<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pagination',[UserController::class,'index'])->name('user.index');
Route::post('pagination/fetch',[UserController::class,'fetch'])->name('user.fetch');

Route::prefix('products')->group(function(){
    Route::get('/',[ProductController::class,'index'])->name('product.index');
    Route::post('/store',[ProductController::class,'store'])->name('product.store');
    Route::post('/update',[ProductController::class,'update'])->name('product.update');
    Route::post('/delete',[ProductController::class,'delete'])->name('product.delete');
    Route::get('/paginate-data',[ProductController::class,'pagination'])->name('product.pagination');
    Route::get('/search',[ProductController::class,'search'])->name('product.search');
});