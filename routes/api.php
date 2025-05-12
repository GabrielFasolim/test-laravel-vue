<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;

/*
|------------------------------------------------------------------
| Rotas públicas de teste
|------------------------------------------------------------------
*/
Route::get('/ping', fn () => response()->json(['pong' => true]));

/*
|------------------------------------------------------------------
| Rotas protegidas por Sanctum
|------------------------------------------------------------------
*/

    // Emite um Sanctum token via email/senha
Route::post('/token', function (Request $request) {
    // tenta autenticar as credenciais
    if (! Auth::attempt($request->only('email','password'))) {
        return response()->json(['message' => 'Credenciais inválidas'], 401);
    }
    // retorna o token recém-criado
    return ['token' => $request->user()->createToken('api')->plainTextToken];
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/posts',  [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
});
