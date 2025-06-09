<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Certifique-se que seu model User está aqui
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth; // Para usar auth()->id()
use Illuminate\Support\Facades\Hash; // Para bcrypt no store/update

class UserController extends Controller
{

    public function index()
    {
        // Ordenar por 'is_active' descendentemente primeiro, depois por 'created_at'
        // Isso coloca os usuários ativos no topo da lista se você preferir.
        $users = User::orderBy('is_active', 'desc') 
                     ->orderBy('created_at', 'desc')
                     ->paginate(10); 
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean', // Adicionado para criação
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Usar Hash::make
            'is_admin' => $request->boolean('is_admin'), // Usar boolean() para obter valor correto
            'is_active' => $request->boolean('is_active', true), // Default true se não enviado
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return redirect()->route('admin.users.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'is_admin' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean', // Adicionado para edição
        ]);

        $userData = $request->only(['name', 'email']);
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password); // Usar Hash::make
        }
        
        // Apenas atualiza se o campo for enviado no request
        if ($request->has('is_admin')) {
            $userData['is_admin'] = $request->boolean('is_admin');
        }
        if ($request->has('is_active')) {
            $userData['is_active'] = $request->boolean('is_active');
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (FacadesAuth::id() === $user->id) { // Usar FacadesAuth::id()
            return redirect()->route('admin.users.index')->with('error', 'Você não pode excluir seu próprio usuário.');
        }

        // Regra opcional: Não permitir excluir o último administrador
        // if ($user->is_admin && User::where('is_admin', true)->count() === 1) {
        //    return redirect()->route('admin.users.index')->with('error', 'Não é possível excluir o último administrador.');
        // }
        
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuário excluído com sucesso!');
    }

    /**
     * Toggle the active status of the specified user.
     */
    public function toggleActiveStatus(Request $request, User $user) // Adicionado Request $request
    {
        // Regra de segurança: Não permitir desativar o próprio usuário logado.
        if ($user->id === FacadesAuth::id()) { // Usar FacadesAuth::id()
             return redirect()->route('admin.users.index')->with('error', 'Você não pode alterar seu próprio status de atividade.');
        }
        
        // Regra de segurança opcional: Não permitir desativar o último administrador ativo.
        // Isso previne que você se tranque fora do sistema se só houver um admin.
        // if ($user->is_admin && $user->is_active && User::where('is_admin', true)->where('is_active', true)->count() === 1) {
        //    return redirect()->route('admin.users.index')->with('error', 'Não é possível desativar o último administrador ativo do sistema.');
        // }

        $user->is_active = !$user->is_active; // Alterna o valor booleano
        $user->save();

        $statusMessage = $user->is_active ? 'ativado' : 'desativado';
        return redirect()->route('admin.users.index')->with('success', "Usuário '{$user->name}' foi {$statusMessage} com sucesso.");
    }
}