<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Illuminate\Http\Request;


class UsersController extends Controller
{
    public function index()
    {
        $roles = Role::where('name','admin')->first();


        return Inertia::render('User/Index', [
            'users' => User::role('admin')->orderBy('name')
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($user) => [
                'id' => $user->id,
                'username' => $user->username,
                'name' => $user->name,
                'email' => $user->email,
            ]),]);
    }

    public function create()
    {
        return Inertia::render('User/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required','min:3'],
            'username' => ['required','min:3'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $password = bcrypt($validated['password']);
        $user = User::create([
            'username' =>  $validated['username'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $password,
        ]);

        $role = Role::firstOrCreate(['name' => 'Admin']);
        $user->assignRole($role);

        return Redirect::route('users.index')->with('success', 'Users created.');
    }

    public function edit(User $user)
    {
        return Inertia::render('User/Edit',[
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'password' =>  $user->password,
            ]
        ]);
    }

    public function update(Request $request,User $user)
    {
        $validated = $request->validate([
            'name' => ['required','min:3'],
            'username' => ['required','min:3'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user->update($validated);

        return Redirect::route('user.index')->with('success', 'Users updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return Redirect::route('user.index')->with('success', 'Users Deleted.');
    }
}
