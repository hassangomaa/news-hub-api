<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index'); // List all articles with filters and pagination
// List all authors with optional filters and pagination
Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
// List all sources with optional filters and pagination
Route::get('/sources', [SourceController::class, 'index'])->name('sources.index');
// List all categories with optional filters and pagination
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
