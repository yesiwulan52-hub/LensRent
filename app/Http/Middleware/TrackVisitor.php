<?php

namespace App\Http\Middleware;
use Closure;
class TrackVisitor
{
    public function handle($request, Closure $next)
    {
        if (!session()->has('visit_count')) {
            session()->put('visit_count', 1);
            session()->put('first_visit', now()->toDateTimeString());
            session()->put('last_visit', now()->toDateTimeString());
        } else {
            session()->increment('visit_count');
            session()->put('last_visit', now()->toDateTimeString());
        }
        return $next($request);
    }
}
