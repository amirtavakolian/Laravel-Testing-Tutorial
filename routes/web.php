<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'posts'], function () {
    Route::get('/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/store', [PostController::class, 'store'])->name('posts.store')->middleware('auth');
    Route::get('/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/{post}/update', [PostController::class, 'update'])->name('posts.update');
    Route::get('/{post}', [PostController::class, 'show'])->name('posts.show');
});

Route::group(['prefix' => 'auth', 'middleware' => 'guest'], function () {
    Route::get('/register', [AuthController::class, 'view'])->name('auth.index');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::get('/login', [AuthController::class, 'loginIndex'])->name('auth.login.index');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});

Route::group(['prefix' => '/comment', 'middleware' => 'auth'], function () {
    Route::post('/{post}/store', [CommentController::class, 'store'])->name('comment.store');
});
