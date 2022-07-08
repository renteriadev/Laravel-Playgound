<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;


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
//post routers;
Route::controller(PostController::class)->group(function () {
    Route::post('/create', 'createPost')->middleware('test_auth');
    Route::get('/posts', 'GetAllPost');
    Route::get('/post/{id}', 'getPostById')->middleware('test_auth');
    Route::delete('/post/{id}', 'detelePostById')->middleware('test_auth');
    Route::put('/post/{id}', 'updatePostById')->middleware('test_auth');
    Route::get('/posts/{id}/user', 'listPostsByUserId')->middleware('test_auth');
    Route::post('/post/dates', 'findingPostByDates')->middleware('test_auth');
});

//users routers;
Route::controller(UserController::class)->group(function () {
    Route::post('/user/create', 'registerUser');
    Route::post('/user/login', 'loginUser');
});
//

//images routers;
Route::controller(ImageController::class)->group(function () {
    Route::post('/image', 'creatingNewImage')->middleware('test_auth');
    Route::delete('/image/{id}', 'deleteImage')->middleware('test_auth');
    Route::post('/image/{id}/{postId}', 'updateImageCreated')->middleware('test_auth');
    Route::get('/image/{id}', 'gettingImageById')->middleware('test_auth');
    Route::put('/several/{id}/images', 'updateManyImages')->middleware('test_auth');
});

//order routers;
Route::controller(OrderController::class)->group(function () {
    Route::post('/order', 'generateOrder')->middleware('test_auth');
    Route::put('/order/{id}', 'acceptOrDeclineOrder')->middleware('test_auth');
    Route::get('/order/{user_id}', 'listingUser')->middleware('test_auth');
});
