<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Middleware globali che vengono eseguiti su ogni richiesta HTTP
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class, // <--- Mantiene solo questo
    ];
}
