<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends Controller   // ⬅️  hérite du contrôleur qui contient déjà ValidatesRequests
{
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        $this->middleware('permission:role-create',  ['only' => ['create','store']]);
        $this->middleware('permission:role-edit',    ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete',  ['only' => ['destroy']]);
    }

    public function index(Request $request): View
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(5);
        return view('roles.index', compact('roles'))
               ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        $permission = Permission::all();
        return view('roles.create', compact('permission'));
    }

    public function store(Request $request): RedirectResponse
{
    $this->validate($request, [
        'name'         => 'required|unique:roles,name',
        'permission'   => 'required|array|min:1',
        'permission.*' => 'integer|exists:permissions,id',
    ]);

    $role = Role::create(['name' => $request->name]);

    // 👇  on caste en int pour que Spatie reconnaisse des IDs
    $role->syncPermissions(
        collect($request->permission)->map(fn($id) => (int) $id)->all()
    );

    return redirect()->route('roles.index')
                     ->with('success', 'Rôle créé avec succès !');
}


    public function show(int $id): View
    {
        $role            = Role::findOrFail($id);
        $rolePermissions = Permission::whereHas('roles', fn($q) => $q->where('id', $id))->get();

        return view('roles.show', compact('role', 'rolePermissions'));
    }

    public function edit(int $id): View
    {
        $role            = Role::findOrFail($id);
        $permission      = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    public function update(Request $request, Role $role): RedirectResponse
{
    $this->validate($request, [
        'name'         => 'required',
        'permission'   => 'required|array|min:1',
        'permission.*' => 'integer|exists:permissions,id',
    ]);

    $role->update(['name' => $request->name]);

    $role->syncPermissions(
        collect($request->permission)->map(fn($id) => (int) $id)->all()
    );

    return redirect()->route('roles.index')
                     ->with('success', 'Rôle mis à jour avec succès');
}

    public function destroy(int $id): RedirectResponse
    {
        Role::findOrFail($id)->delete();
        return redirect()->route('roles.index')
                         ->with('success', 'Rôle supprimé avec succès');
    }
}
