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

Route::middleware('auth:sanctum')->get('/AuthTest', function() {
    return "You're Authentificated && You can see this page!";
});


route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware('auth:sanctum');

