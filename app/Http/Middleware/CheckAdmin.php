<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar se está logado
        if (!session()->has('user_id')) {
            return redirect()->route('login')
                ->with('error', 'Você precisa estar logado!');
        }
        
        // Verificar se é admin (cargo_id = 4)
        if (session('user_cargo') != 2) {
            return redirect()->route('home')    
                ->with('error', 'Acesso negado! Apenas administradores.');
        }
        
        return $next($request);
    }
}