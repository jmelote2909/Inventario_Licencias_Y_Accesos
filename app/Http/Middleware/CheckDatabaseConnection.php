<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDatabaseConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si ya estamos en la página de ajustes, dejar pasar
        if ($request->is('db-settings') || $request->is('livewire/*')) {
            return $next($request);
        }

        try {
            \Illuminate\Support\Facades\DB::connection()->getPdo();
        } catch (\Exception $e) {
            // Si falla la conexión, redirigir a ajustes con un mensaje informativo
            return redirect()->route('db-settings')->with('message', 'No se ha podido conectar con la base de datos. Por favor, revisa la configuración.');
        }

        return $next($request);
    }
}
