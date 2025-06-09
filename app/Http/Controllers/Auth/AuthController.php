<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User; // Certifique-se de que seu modelo User está aqui
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Para hashear senhas
use Illuminate\Auth\Events\Registered; // Para disparar o evento de registro (opcional, mas bom para coisas como verificação de email)
use Illuminate\Validation\Rules; // Para regras de validação de senha mais robustas
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Exibe o formulário de registro.
     */
    public function showRegistrationForm()
    {
        return view('auth.register'); // Certifique-se que 'auth/register.blade.php' existe
    }

    /**
     * Processa a tentativa de registro.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // 'unique:users' verifica se o email já existe na tabela users
            'password' => ['required', 'confirmed', Rules\Password::defaults()], // 'confirmed' verifica se password_confirmation combina
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user)); // Dispara o evento (opcional)

        Auth::login($user); // Loga o usuário automaticamente após o registro

        return redirect(route('home')); // Redireciona para a home ou dashboard
    }

    /**
     * Exibe o formulário de login.
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Certifique-se que 'auth/login.blade.php' existe
    }

    /**
     * Processa a tentativa de login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    /**
     * Faz o logout do usuário.
     */
    public function logout(Request $request)
    {
        //dd('Dentro do método AuthController@logout'); // <<< ADICIONE ESTA LINHA

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}