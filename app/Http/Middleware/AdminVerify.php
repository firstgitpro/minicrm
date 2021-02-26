<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $current_uri = $request->getRequestUri();
        $ignore_uri = [
            '/admin/login',
            '/admin/logout'
        ];
        if (in_array($current_uri, $ignore_uri)) {
            return $next($request);
        } else {
            if (Auth::guard('admin')->check()) {
                return $next($request);
            } else {
                return redirect('/admin/login');
            }
        }

    }

}