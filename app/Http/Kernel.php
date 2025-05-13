<?php
protected $middlewareGroups = [
    'api' => [
        \Fruitcake\Cors\HandleCors::class,  // ← aqui
        'throttle:api',
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],
];