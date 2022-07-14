<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [  //добавляем исключения для обработки запросов
        '/user',
        '/users/{id}',
        '/user/*',
        '/user/search/{email}',
        '/file/*',
        '/file',
        '/file/{id}',
        '/directory/*',
        '/directory',
        '/directory/{id}',
        '/files/share/{id}',
        '/files/share',
        '/files/shares/{id}',
    ];
}
