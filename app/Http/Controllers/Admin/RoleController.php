<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

use Inertia\Inertia;
use Spatie\Permission\Contracts\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return Inertia::render('Roles/Index', [
            'roles' => Role::orderBy('id')
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($role) => [
                'id' => $role->id,
                'name' => $role->name,
            ]),]);
    }

    public function create()
    {
        return Inertia::render('Roles/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required','min:3'],
        ]);
        Role::create($validated);

        return Redirect::route('roles.index')->with('success', 'Roles created.');
    }

    public function edit(Role $role)
    {
        return Inertia::render('Roles/Edit',[
            'role' => [
                'id' => $role->id,
                'name' => $role->name,
            ]
        ]);
    }

    public function update(Request $request,Role $role)
    {
        $validated = $request->validate([
            'name' => ['required','min:3'],
        ]);

        $role->update($validated);

        return Redirect::route('roles.index')->with('success', 'Roles updated.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return Redirect::route('roles.index')->with('success', 'Roles Deleted.');
    }
}
