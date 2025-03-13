<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('/', function () {
    return "Hello World";
});



Route::post('/register', [App\Http\Controllers\API\Auth::class, 'register']);
Route::post('/login', [App\Http\Controllers\API\Auth::class, 'login']);
Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout', [App\Http\Controllers\API\Auth::class, 'logout']);
});


// route pour tester l'authentification et le token
// aussi pour avoir le role d'user connecté

Route::middleware('auth:sanctum')->get('/AuthTest', function() {

    $user = auth()->user();
    $roles = $user->getRoleNames();
    return response()->json([
        'user' => $user,
        'roles' => $roles
    ]);
});


route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware('auth:sanctum');

// route pour les statistics d super admin

route::get('/stats', [App\Http\Controllers\DashboardController::class, 'stats'])->middleware('auth:sanctum');


// routes dial products kamlin

route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->middleware('auth:sanctum');
route::post('/products/create', [App\Http\Controllers\ProductController::class, 'store'])->middleware('auth:sanctum');
route::get('/products/{id}', [App\Http\Controllers\ProductController::class, 'show'])->middleware('auth:sanctum');
route::put('/products/update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->middleware('auth:sanctum');
route::post('/products/delete/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->middleware('auth:sanctum');


// Categories Routes ya kho 

route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->middleware('auth:sanctum');
route::post('/categories/create', [App\Http\Controllers\CategoryController::class, 'store'])->middleware('auth:sanctum');
route::get('/categories/{id}', [App\Http\Controllers\CategoryController::class, 'show'])->middleware('auth:sanctum');
route::put('/categories/update/{id}', [App\Http\Controllers\CategoryController::class, 'update'])->middleware('auth:sanctum');
route::post('/categories/delete/{id}', [App\Http\Controllers\CategoryController::class, 'destroy'])->middleware('auth:sanctum');


// Product Image Routes

route::get('/product_images', [App\Http\Controllers\ProductImageController::class, 'index']);
route::post('/product_images/create', [App\Http\Controllers\ProductImageController::class, 'store']);
route::post('/product_images/delete/{id}', [App\Http\Controllers\ProductImageController::class, 'destroy']);


// User Management Routes

route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->middleware('auth:sanctum');
route::get('/users/{id}', [App\Http\Controllers\UserController::class, 'show'])->middleware('auth:sanctum');
route::post('/users/create', [App\Http\Controllers\UserController::class, 'store'])->middleware('auth:sanctum');
route::post('/users/delete/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->middleware('auth:sanctum');
