<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;

/*
|--------------------------------------------------------------------------
| Preflight CORS (OPTIONS) – habilita CORS para qualquer rota de /api/*
|--------------------------------------------------------------------------
*/
Route::options('{any}', function (Request $request) {
    return response()->json([], 200)
        ->header('Access-Control-Allow-Origin', '*')              // ou substitua por 'http://localhost:5173'
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
})->where('any', '.*');

/*
|--------------------------------------------------------------------------
| Rotas públicas de teste
|--------------------------------------------------------------------------
*/
Route::get('/ping', fn () => response()->json(['pong' => true]));

/*
|--------------------------------------------------------------------------
| Rotas protegidas por Sanctum
|--------------------------------------------------------------------------
*/
// Emite um Sanctum token via email/senha
Route::post('/token', function (Request $request) {
    if (! Auth::attempt($request->only('email','password'))) {
        return response()->json(['message' => 'Credenciais inválidas'], 401);
    }
    return ['token' => $request->user()->createToken('api')->plainTextToken];
});

// Rotas que exigem autenticação
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/posts',  [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
});
