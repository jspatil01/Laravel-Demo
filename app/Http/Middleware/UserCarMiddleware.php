<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Car;
class UserCarMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth()->user();
        $carID = $request->route('car')->id;
        $car = Car::where('id', $carID)
                  ->where('user_id', $user->id)->first();
        if ($car) {
            return $next($request);
        }
        return response()->json([
            "message"=>"You do not have permission to access this resource!"
        ], 403);
    } 
}
