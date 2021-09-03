<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('login',[ProductController::class,'login'])->name('login');
Route::get('productlist',[ProductController::class,'getProductList'])->name('productlist');
Route::post('order',[ProductController::class,'order'])->name('order');
Route::post('addproduct',[ProductController::class,'addProduct'])->name('addproduct');
Route::post('userdata',[ProductController::class,'getUserdata'])->name('userdata');
Route::get('userdetails',[ProductController::class,'getAllUserData'])->name('userdetails');
Route::post('updatestatus',[ProductController::class,'getUpdatests'])->name('updatestatus');
Route::post('cancelorder',[ProductController::class,'cancelOrder'])->name('cancelorder');

