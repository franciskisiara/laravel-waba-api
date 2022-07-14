<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CaretakerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $caretaker = $request->route('apartment')->caretaker;

        if ($caretaker->id !== $request->user()->id) {
            return response()->json([
                'message' => '\App\Models\Apartment not found'
            ], 404);
        }

        return $next($request);
    }
}
