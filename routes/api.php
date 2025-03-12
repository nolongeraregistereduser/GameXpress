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