<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Sessions as SessionsController;
use App\Http\Controllers\Document as DocumentController;
use App\Http\Controllers\Feedback as FeedbackController;
use App\Http\Controllers\Image as ImageController;
use App\Http\Controllers\Main as MainController;
use App\Http\Controllers\Photo as PhotoController;
use App\Http\Controllers\Profile as ProfileController;

Route::middleware('auth:sanctum')->get('/get', [ SessionsController::class, 'getUser' ]);
Route::get('/test', [MainController::class, 'test'])->middleware('can:dev');
Route::prefix('main-info')->group(function () {
    Route::get('/', [MainController::class, 'getMainInfo']);
    Route::middleware(['auth', 'can:moderator'])->group(function() {
        Route::post('/store', [MainController::class, 'createMainInfo']);
        Route::put('/update/{mainInfo}', [MainController::class, 'updateMainInfo']);
        Route::get('/all', [MainController::class, 'allInfo']);
        Route::get('/{mainInfoTeacher}/one', [MainController::class, 'oneInfo']);
        Route::put('/{mainInfoTeacher}/change-active', [MainController::class, 'changeActive']);
        Route::delete('/{mainInfoTeacher}/delete', [MainController::class, 'deleteMainInfo']);
    });
});
Route::prefix('image')->group(function () {
    Route::post('/save-main-info', [ImageController::class, 'saveImageMain'])->middleware(['can:moderator']);
    Route::delete('/{mainInfoTeacher}/delete', [ImageController::class, 'deleteImageMain'])->middleware(['can:moderator']);
    Route::prefix('photo')->group(function () {
        Route::get('/index', [PhotoController::class, 'index']);
        Route::post('/store', [PhotoController::class, 'store'])->middleware(['can:moderator']);
        Route::delete('/{photo}/delete', [PhotoController::class, 'delete'])->middleware(['can:moderator']);
    });
});

Route::prefix('document')->group(function () {
    Route::get('/index', [DocumentController::class, 'index']);
    Route::post('/store', [DocumentController::class, 'store'])->middleware(['can:moderator']);
    Route::delete('/{document}/destroy', [DocumentController::class, 'destroy'])->middleware(['can:moderator']);
});

Route::prefix('profile')->middleware('auth')->group(function () {
    Route::put('/edit', [ProfileController::class, 'edit']);
    Route::put('/changePassword', [ProfileController::class, 'changePassword']);
    Route::delete('/{id}', [ProfileController::class, 'destroy']);
    Route::put('/changeAvatar', [ProfileController::class, 'changeAvatar']);
    Route::put('/deleteAvatar', [ ProfileController::class, 'deleteAvatar']);
});

Route::prefix('feedback')->group(function () {
    Route::get('/', [FeedbackController::class, 'index'])->middleware(['can:moderator']);
    Route::post('/store', [FeedbackController::class, 'store']);
});
