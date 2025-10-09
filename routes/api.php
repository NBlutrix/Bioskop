<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('movies', MoviesController::class);

Route::get('movies/{movie}/ratings', [RatingsController::class, 'index']);
Route::post('movies/{movie}/ratings', [RatingsController::class, 'store']);
Route::put('ratings/{id}', [RatingsController::class, 'update']);
Route::delete('ratings/{id}', [RatingsController::class, 'destroy']);

Route::get('movies/{movie}/comments', [CommentsController::class, 'index']);
Route::post('movies/{movie}/comments', [CommentsController::class, 'store']);
Route::put('comments/{id}', [CommentsController::class, 'update']);
Route::delete('comments/{id}', [CommentsController::class, 'destroy']);


Route::middleware('auth:sanctum')->group(function() {
    Route::post('movies', [MoviesController::class, 'store']);
    Route::put('movies/{movie}', [MoviesController::class, 'update']);
    Route::delete('movies/{movie}', [MoviesController::class, 'destroy']);

    Route::post('movies/{movie}/ratings', [RatingsController::class, 'store']);
    Route::put('ratings/{id}', [RatingsController::class, 'update']);
    Route::delete('ratings/{id}', [RatingsController::class, 'destroy']);

    Route::post('movies/{movie}/comments', [CommentsController::class, 'store']);
    Route::put('comments/{id}', [CommentsController::class, 'update']);
    Route::delete('comments/{id}', [CommentsController::class, 'destroy']);
});
