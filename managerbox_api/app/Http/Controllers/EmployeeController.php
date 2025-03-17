<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\Http\SendJsonResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    use SendJsonResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();

        return View::make('employees.create')->with([
            'roles' => $roles,
        ])->render();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Verificar se o usuário está autenticado
            if (!auth()->check()) {
                return response()->json(['error' => 'Usuário não autenticado.'], 401);
            }

            $validatedData = $request->validate([
                'name' => ['required', 'string', 'min:3', 'max:255'],
                'email' => ['required', 'string', 'email', 'unique:users,email', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'max:255'],
                'cpf' => ['required', 'string', 'size:11', 'unique:users,cpf'],
                'phone_number' => ['nullable', 'string', 'size:11'],
                'is_active' => ['required', 'boolean'],
                'role_id' => ['required', 'integer', 'exists:roles,id']
            ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'],
                'cpf' => $validatedData['cpf'],
                'phone_number' => $validatedData['phone_number'],
                'is_active' => $validatedData['is_active'],
                'company_id' => Session::get('company_id'),
            ]);

            $role = Role::find($validatedData['role_id']);
            $user->assignRole($role);

            return redirect()->back()->with('success', 'Usuário cadastrado com sucesso!');

        } catch (\Exception $exception) {
            Log::error($exception);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return View::make('users.show')->with([
            'user' => $user,
        ])->render();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return View::make('users.edit')->with([
            'user' => $user,
            'roles' => $roles,
        ])->render();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            // Verificar se o usuário está autenticado
            if (!auth()->check()) {
                return response()->json(['error' => 'Usuário não autenticado.'], 401);
            }

            $validatedData = $request->validate([
                'name' => ['required', 'string', 'min:3', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'max:255'],
                'cpf' => ['required', 'string', 'size:11', 'unique:users,cpf'],
                'phone_number' => ['nullable', 'string', 'size:11'],
                'is_active' => ['required', 'boolean'],
                'role_id' => ['nullable', 'integer', 'exists:roles,id']
            ]);

            $user = User::findOrFail($id);

            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'],
                'cpf' => $validatedData['cpf'],
                'phone_number' => $validatedData['phone_number'],
                'is_active' => $validatedData['is_active'],
                'company_id' => Session::get('company_id'),
            ]);

            if($validatedData['role_id']) {
                $role = Role::find($validatedData['role_id']);
                $user->assignRole($role);
            }
            
            return redirect()->back()->with('success', 'Usuário atualizado com sucesso!');

        } catch (\Exception $exception) {
            Log::error($exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'Usuário excluído com sucesso!');
    }
}
