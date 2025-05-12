<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    public function handle(Request $request, Closure $next): Response
    {
        // Se for pré-voo, devolve logo as permissões
        if ($request->getMethod() === 'OPTIONS') {
            return response('', 204, [
                'Access-Control-Allow-Origin'      => 'http://localhost:5173',
                'Access-Control-Allow-Methods'     => 'GET, POST, PUT, PATCH, DELETE, OPTIONS',
                'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-XSRF-TOKEN, X-Requested-With',
                'Access-Control-Allow-Credentials' => 'true',
            ]);
        }

        // Senão, executa a requisição e adiciona os cabeçalhos CORS na resposta
        $response = $next($request);

        $response->headers->set('Access-Control-Allow-Origin',      'http://localhost:5173');
        $response->headers->set('Access-Control-Allow-Methods',     'GET, POST, PUT, PATCH, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers',     'Content-Type, Authorization, X-XSRF-TOKEN, X-Requested-With');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');

        return $response;
    }
}
