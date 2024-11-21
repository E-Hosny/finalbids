<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Config;
use App;


class CurrencyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     return $next($request);
    // }
    public function handle($request, Closure $next)
    {
        if (session()->has('currency')) {
            Config::set('app.currency', session()->get('currency'));
        } else {
            Config::set('app.currency', 'SAR');

            session()->put('currency', 'SAR');
        }

        return $next($request);
    }
}
