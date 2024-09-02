<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VariantsController;
use App\Http\Controllers\frontend\cartController;
use App\Http\Controllers\ProductsController;

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



Route::resource('products', ProductsController::class);
Route::get('/delete-product/{id}',[ProductsController::class,'DeleteProduct'])->name('product.delete');


// custome method
Route::get('/products/{id}/add_product_variants', [ProductsController::class, 'AddProductVariants'])->name('products.add_product_variant');
Route::post('/products/{id}/save_product_variants', [ProductsController::class, 'SaveProductVariants'])->name('products.save_product_variants');
Route::get('/delete-product-variants/{id}',[ProductsController::class,'DeleteProductVariant'])->name('product-variants.delete');

Route::get('/products/{id}/add_product_variant_options', [ProductsController::class, 'AddProductVariantOption'])->name('products.add_product_variant_option');
Route::post('/products/{id}/save_product_variant_options', [ProductsController::class, 'SaveProductVariantOption'])->name('products.save_product_variant_option');
Route::get('delete-variant-option/{id}',[ProductsController::class,'DeleteProductVariantOption'])->name('product-variant-option.delete');


// frontend
Route::get('/', [cartController::class, 'AllProducts'])->name('frontend.all-products');
Route::post('/add-to-cart', [cartController::class, 'AddToCart'])->name('frontend.add-to-cart');
Route::get('/cart', [cartController::class, 'Cart'])->name('frontend.cart');
Route::post('/update-cart', [cartController::class, 'UpdateCart'])->name('frontend.update-cart');
Route::get('/delete-cart/{id}', [cartController::class, 'DeleteCart'])->name('cart.delete');


Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');

