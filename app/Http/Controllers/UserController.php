<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {   
        $entities = Entity::select('id', 'name', 'key')
            ->orderBy('name')
            ->get();   
        $users = User::with('roles')->latest()->paginate(10);
        return view('users.index', compact('users', 'entities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'entity_id' => ['required', 'exists:entities,key'],
            'role' => ['required', Rule::in(['admin', 'capturista'])],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'entity_id' => $request->entity_id,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()
            ->route('users.index')
            ->with('success', "Usuario registrado con rol " . ucfirst($request->role) . " correctamente.");
    }
}