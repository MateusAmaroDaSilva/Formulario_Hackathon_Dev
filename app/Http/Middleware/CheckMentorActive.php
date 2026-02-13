<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckMentorActive
{
    /**
     * Verifica se o mentor está ativo.
     * Se foi inativado, desloga automaticamente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $mentor = Auth::guard('mentor')->user();
        
        // Se está autenticado mas com status inativo
        if ($mentor && $mentor->status !== 'ativo') {
            
            // Desloga imediatamente
            Auth::guard('mentor')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login.unificado')
                ->withErrors(['email' => 'Sua conta foi desativada. Entre em contato com o administrador.']);
        }
        
        return $next($request);
    }
}
