<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Middleware\HandleCors as Middleware;

class HandleCors extends Middleware
{
    protected function shouldRun(Request $request): bool
    {
        return App::environment() !== 'testing';
    }
}
