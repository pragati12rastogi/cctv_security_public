<?php

namespace App\Http\Middleware;

use Closure;

class IsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $isactive = 1;
        
        if ($isactive) {
            if ($isactive == 1) {
                
                $response = $next($request);
                
                $response->headers->set('Access-Control-Allow-Origin' , '*');
                $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
                $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application');

                return $response;

            } else {
                 return abort('401', 'Unauthorized action');

            }
        } else {
             return abort('401', 'Unauthorized action');
        }
    }
}
