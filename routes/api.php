<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aqui ficam seus endpoints JSON. Protegemos por sessão (Breeze) ou
| por token (Sanctum), dependendo de quem você escolher.
|
*/

Route::middleware('auth')->group(function () {
    // Listagem de posts de um usuário
    Route::get('/posts',  [PostController::class, 'index']);
    // Criação de post (somente admin)
    Route::post('/posts', [PostController::class, 'store']);
});
