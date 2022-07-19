<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\EnsureTokenIsValid;


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
Route::middleware([EnsureTokenIsValid::class])->group(function () {
    Route::post('/create', [PostController::class, 'createPost']);
    Route::get('/posts', [PostController::class, 'GetAllPost']);
    Route::get('/post/{id}', [PostController::class, 'getPostById']);
    Route::delete('/post/{id}', [PostController::class, 'detelePostById']);
    Route::put('/post/{id}', [PostController::class, 'updatePostById']);
    Route::get('/posts/{id}/user', [PostController::class, 'listPostsByUserId']);
    Route::post('/post/dates', [PostController::class, 'findingPostByDates']);
});

//users routers;
Route::middleware([EnsureTokenIsValid::class])->group(function () {
    Route::post('/user/create', [UserController::class, 'registerUser'])->withoutMiddleware([EnsureTokenIsValid::class]);
    Route::post('/user/login', [UserController::class, 'loginUser'])->withoutMiddleware([EnsureTokenIsValid::class]);
    Route::get('/user/{id}', [UserController::class, 'findUserById']);
});
//

//images routers;
Route::middleware(EnsureTokenIsValid::class)->group(function () {
    Route::post('/image', [ImageController::class, 'creatingNewImage']);
    Route::delete('/image/{id}', [ImageController::class, 'deleteImage']);
    Route::post('/image/{id}/{postId}', [ImageController::class, 'updateImageCreated']);
    Route::get('/image/{id}', [ImageController::class, 'gettingImageById']);
    Route::put('/several/{id}/images', [ImageController::class, 'updateManyImages']);
});

//order routers;
Route::controller(EnsureTokenIsValid::class)->group(function () {
    Route::post('/order', [OrderController::class, 'generateOrder']);
    Route::put('/order/{id}', [OrderController::class, 'acceptOrDeclineOrder']);
    Route::get('/order/{user_id}', [OrderController::class, 'listingUser']);
});
