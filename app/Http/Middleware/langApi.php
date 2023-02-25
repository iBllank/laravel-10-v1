<?php

namespace App\Http\Middleware;

use Closure;
use App\Constants\Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class langApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if( $request->headers->has('lang') ) {
            if ($lang = $request->headers->get('lang')) {
                if(in_array($lang,Constants::AVAILABLE_LANGUAGES))
                    App::setLocale($lang);
            }
        }
        return $next($request);
    }
}
