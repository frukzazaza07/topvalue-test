<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::prefix('authen')->group(function () {
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'index']);
    Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'authenticate']);
    Route::get('/register', [\App\Http\Controllers\AuthController::class, 'indexRegister']);
    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
});

//route resource
Route::group(['prefix' => 'uploads', 'middleware' => ['auth']], function(){
    Route::get('/', [\App\Http\Controllers\UploadController::class, 'index']);
    Route::get('/create', [\App\Http\Controllers\UploadController::class, 'create']);
    Route::post('/store', [\App\Http\Controllers\UploadController::class, 'store']);
    Route::get('/edit/{id}', [\App\Http\Controllers\UploadController::class, 'edit']);
    Route::put('/update/{id}', [\App\Http\Controllers\UploadController::class, 'update']);
    Route::delete('/destroy/{id}', [\App\Http\Controllers\UploadController::class, 'destroy']);
});

Route::group(['prefix' => 'categorys', 'middleware' => ['auth']], function(){
    Route::get('/', [\App\Http\Controllers\CategoryController::class, 'index']);
    Route::get('/create', [\App\Http\Controllers\CategoryController::class, 'create']);
    Route::post('/store', [\App\Http\Controllers\CategoryController::class, 'store']);
    Route::get('/edit/{id}', [\App\Http\Controllers\CategoryController::class, 'edit']);
    Route::put('/update/{id}', [\App\Http\Controllers\CategoryController::class, 'update']);
    Route::delete('/destroy/{id}', [\App\Http\Controllers\CategoryController::class, 'destroy']);
});
Route::group(['prefix' => 'category-relation', 'middleware' => ['auth']], function(){
    Route::get('/view/{id}', [\App\Http\Controllers\CategoryRelationController::class, 'index']);
    Route::get('/create', [\App\Http\Controllers\CategoryRelationController::class, 'create']);
    Route::post('/store', [\App\Http\Controllers\CategoryRelationController::class, 'store']);
    Route::get('/edit/{id}', [\App\Http\Controllers\CategoryRelationController::class, 'edit']);
    Route::put('/update/{id}', [\App\Http\Controllers\CategoryRelationController::class, 'update']);
    Route::delete('/destroy/{id}', [\App\Http\Controllers\CategoryRelationController::class, 'destroy']);
});
