<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Necessário para hashing de senha
use Illuminate\Validation\Rules\Password; // Necessário para as regras de validação de senha do Laravel
// Se você for implementar o reenvio de verificação de e-mail, precisará disso:
// use Illuminate\Auth\Events\Registered; 

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Aplica o middleware 'auth' a todos os métodos neste controller,
        // garantindo que apenas usuários autenticados possam acessá-los.
        $this->middleware('auth');
    }

    /**
     * Display the user's account dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        // Contar pedidos do usuário para exibir na página da conta
        $orderCount = $user->orders()->count(); 

        return view('account.index', compact('user', 'orderCount'));
    }

    /**
     * Show the form for editing the user's profile.
     *
     * @return \Illuminate\View\View
     */
    public function editProfile()
    {
        $user = Auth::user();
        return view('account.edit-profile', compact('user'));
    }

    /**
     * Update the user's profile information (name and email).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // A regra 'unique' verifica se o email é único na tabela 'users',
            // ignorando o ID do usuário atual para permitir que ele mantenha seu próprio email.
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        // Se o e-mail foi alterado e seu sistema usa verificação de e-mail,
        // você deve marcar o novo e-mail como não verificado.
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            // Se você tiver um sistema de notificação de verificação de email, dispare-o aqui
            // Ex: $user->sendEmailVerificationNotification();
            // event(new Registered($user)); // Se você usa o evento Registered para isso
        }

        $user->save();

        // O 'status' => 'profile-updated' é usado para exibir uma mensagem de sucesso na view.
        return redirect()->route('account.edit-profile')->with('status', 'profile-updated');
    }

    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            // 'current_password' verifica se a senha fornecida corresponde à senha atual do usuário.
            'current_password' => ['required', 'string', 'current_password'],
            // 'password' valida a nova senha com as regras padrão do Laravel (Password::defaults())
            // e 'confirmed' garante que o campo 'password_confirmation' corresponda.
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
        ]);

        // Faz o hash da nova senha antes de salvá-la.
        $user->password = Hash::make($validatedData['password']);
        $user->save();

        // O 'status' => 'password-updated' é usado para exibir uma mensagem de sucesso na view.
        return redirect()->route('account.edit-profile')->with('status', 'password-updated');
    }
}