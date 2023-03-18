<?php

namespace App\Http\Controllers\Admin\ACL;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (!Auth::user()->hasPermissionTo('Listar Perfis')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $roles = Role::all();
        return view('admin.roles.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if (!Auth::user()->hasPermissionTo('Cadastrar Perfis')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if (!Auth::user()->hasPermissionTo('Cadastrar Perfis')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $role = Role::where('name', $request->name)->get();
        if ($role->count() > 0) {
            return redirect()->back()->with(['message' => 'Ooops, o nome desse perfil já está em uso!', 'type' => 'warning', 'icon' => 'exclamation-triangle']);
        }
        $role = new Role();
        $role->name = $request->name;
        $role->save();
        return redirect()->route('admin.role.index')->with(['message' => 'Perfil cadastrado com sucesso!', 'type' => 'success', 'icon' => 'check']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        if (!Auth::user()->hasPermissionTo('Editar Perfis')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $role = Role::where('id', $id)->first();
        if (empty($role->id)) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        return view('admin.roles.edit', [
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        if (!Auth::user()->hasPermissionTo('Editar Perfis')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $role = Role::where('name', $request->name)->where('id', '!=', $id)->get();
        if ($role->count() > 0) {
            return redirect()->back()->withInput()->with(['message' => 'Ooops, o nome desse perfil já está em uso!', 'type' => 'warning', 'icon' => 'exclamation-triangle']);
        }
        $role = Role::where('id', $id)->first();
        $role->name = $request->name;
        $role->save();
        return redirect()->route('admin.role.index')-> with(['message' => 'Perfil atualizado com sucesso!', 'type' => 'success', 'icon' => 'check']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if (!Auth::user()->hasPermissionTo('Remover Perfis')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $role = Role::where('id', $id)->first();
        $role->delete();
        return redirect()->route('admin.role.index')->with(['message' => 'Perfil removido com sucesso!', 'type' => 'success', 'icon' => 'trash']);
    }

    public function permissions($role) {
        if (!Auth::user()->hasPermissionTo('Atribuir Permissões')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $role = Role::where('id', $role)->first();
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            if ($role->hasPermissionTo($permission->name)) {
                $permission->can = true;
            } else {
                $permission->can = false;
            }
        }
        return view('admin.roles.permissions', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    public function permissionsSync(Request $request, $role) {
        $permissionsRequest = $request->except(['_token', '_method']);
        foreach ($permissionsRequest as $key => $value) {
            $permissions[] = Permission::where('id', $key)->first();
        }
        $role = Role::where('id', $role)->first();
        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions(null);
        }
        return redirect()->route('admin.role.permissions', ['role' => $role->id])->with(['message' => 'Permissão sincronizada com sucesso!', 'type' => 'success', 'icon' => 'check']);
    }

}
