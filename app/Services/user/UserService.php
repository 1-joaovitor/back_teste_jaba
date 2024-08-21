<?php

namespace App\Services\user;

use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getUsers()
    {
        try {
          
            return User::all();
        } catch (Exception $e) {
            
            throw new Exception('Não foi possível recuperar os usuários: ' . $e->getMessage());
        }
    }

    public function getUserById($id)
    {
        try {
            
            return User::findOrFail($id);
        } catch (Exception $e) {
           
            throw new Exception('Usuário não encontrado: ' . $e->getMessage());
        }
    }

    public function createUser(Request $request)
    {
        try {
            
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string|max:15',
                'document' => 'required|string|max:20',
                'password' => 'required|string|min:8|confirmed',
            ]);

           
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'document' => $request->document,
                'password' => Hash::make($request->password),
            ]);

            return $user;
        } catch (Exception $e) {
           
            throw new Exception('Não foi possível criar o usuário: ' . $e->getMessage());
        }
    }

    public function editUser(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

           
            $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:users,email,' . $id,
                'phone' => 'sometimes|required|string|max:15',
                'document' => 'sometimes|required|string|max:20',
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            
            $user->update([
                'name' => $request->input('name', $user->name),
                'email' => $request->input('email', $user->email),
                'phone' => $request->input('phone', $user->phone),
                'document' => $request->input('document', $user->document),
                'password' => $request->has('password') ? Hash::make($request->password) : $user->password,
            ]);

            return $user;
        } catch (Exception $e) {
          
            throw new Exception('Não foi possível atualizar o usuário: ' . $e->getMessage());
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(['message' => 'Usuário removido com sucesso.']);
        } catch (Exception $e) {
          
            throw new Exception('Não foi possível remover o usuário: ' . $e->getMessage());
        }
    }
}
