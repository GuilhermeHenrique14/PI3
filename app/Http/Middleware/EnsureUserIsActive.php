<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importe a facade Auth
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Verifica se há um usuário autenticado
        if (Auth::check()) {
            // 2. Obtém o usuário autenticado
            $user = Auth::user();

            // 3. Verifica se o usuário tem a propriedade 'is_active' e se ela é false
            // É uma boa prática verificar se a propriedade existe antes de acessá-la,
            // embora se você seguiu os passos da migration e do model, ela deve existir.
            if (property_exists($user, 'is_active') && !$user->is_active) {
                // Opcional: Determine para onde redirecionar após o logout,
                // pode ser útil se você tiver diferentes "homes" para admin e usuário comum.
                // $intendedUrl = $user->is_admin ? route('admin.dashboard') : route('home');

                // 4. Faz logout do usuário inativo
                Auth::logout();

                // 5. Invalida a sessão e regenera o token CSRF
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // 6. Redireciona para a página de login com uma mensagem de erro
                return redirect()->route('login')
                    ->with('error', 'Sua conta está inativa. Por favor, entre em contato com o suporte.');
            }
        }

        // 7. Se o usuário estiver ativo ou não estiver logado, continua para a próxima requisição
        return $next($request);
    }
}