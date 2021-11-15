<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Users/UserIndex', [
            'users' => UserResource::collection(User::all())
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/UserCreate', [
            'roles' => Role::query()->select('id', 'name')->get()->pluck('name', 'id'),
            'companies' => Company::query()->select('id', 'name')->get()->pluck('name', 'id'),
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        dd($request->all());
       User::create($request->validated());

        return redirect()->route('users.index')->with('status', 'User created successfully!');
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/UserEdit', [
            'roles' => RoleResource::collection(Role::all()),
            'user' => new UserResource($user),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        if (!$data['password']) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('status', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('status', 'User deleted successfully!');
    }
}