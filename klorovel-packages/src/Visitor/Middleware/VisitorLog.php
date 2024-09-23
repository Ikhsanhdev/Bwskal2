<?php

namespace AyatKyo\Klorovel\Visitor\Middleware;

use AyatKyo\Klorovel\Visitor\Facades\Visitor;
use Closure;

class VisitorLog
{
    public function handle($request, Closure $next, ...$params)
    {
        Visitor::log();
        
        return $next($request);
    }
}
