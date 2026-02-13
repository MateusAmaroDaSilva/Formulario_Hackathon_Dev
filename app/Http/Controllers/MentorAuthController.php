<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MentorAuthController extends Controller
{
    // Exibe a view de login (se estiver separada)
    // Se for unificada, pule este método
    public function showLoginForm()
    {
        return view('auth.login-mentor');
    }

    public function login(Request $request)
    {
        // 1. Validação básica
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Tenta logar usando o GUARD 'mentor'
        if (Auth::guard('mentor')->attempt($credentials, $request->remember)) {

            // VERIFICAÇÃO: Checa se o usuário está ativo
            $mentor = Auth::guard('mentor')->user();
            
            if ($mentor->status !== 'ativo') {
                // Desloga imediatamente
                Auth::guard('mentor')->logout();
                $request->session()->invalidate();
                
                return back()->withErrors([
                    'email' => 'Sua conta está inativa. Entre em contato com o administrador.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            // 3. Redireciona para o Dashboard do MENTOR
            return redirect()->intended(route('mentor.dashboard'));
        }

        // 4. Se falhar
        return back()->withErrors([
            'email' => 'As credenciais não conferem.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('mentor')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
