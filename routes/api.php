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



Route::post('/register', [App\Http\Controllers\API\Auth::class, 'register']
);
Route::post('/login', [App\Http\Controllers\API\Auth::class, 'login']
);

