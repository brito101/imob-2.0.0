<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\User as UserRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Storage;
use App\Support\Cropper;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (!Auth::user()->hasPermissionTo('Listar Usuários')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $user = User::all();
        return view('admin.users.index', [
            'users' => $user
        ]);
    }

    public function team() {
        if (!Auth::user()->hasPermissionTo('Listar Usuários - Equipe')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $users = User::where('admin', 1)->get();
        return view('admin.users.team', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if (!Auth::user()->hasPermissionTo('Cadastrar Usuários')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $roles = Role::all();
        foreach ($roles as $role) {
            $role->can = false;
        }
        return view('admin.users.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request) {
        if (!Auth::user()->hasPermissionTo('Cadastrar Usuários')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $userCreate = User::create($request->all());
        if (!empty($request->file('cover'))) {
            $userCreate->cover = $request->file('cover')
                    ->storeAs('user', Str::slug($request->name) . '-' . str_replace('.', '', microtime(true)) . '.' . $request->file('cover')
                    ->extension());
            $userCreate->save();
        }
        return redirect()->route('admin.users.edit', [
                    'user' => $userCreate->id
                ])->with(['message' => 'Cliente criado com sucesso!', 'type' => 'success', 'icon' => 'check']);
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
        if (!Auth::user()->hasPermissionTo('Editar Usuários')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $user = User::where('id', $id)->first();
        if (empty($user->id)) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $roles = Role::all();
        foreach ($roles as $role) {
            if ($user->hasRole($role->name)) {
                $role->can = true;
            } else {
                $role->can = false;
            }
        }
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id) {
        if (!Auth::user()->hasPermissionTo('Editar Usuários')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $user = User::where('id', $id)->first();
        if (empty($user->id)) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $user->setLessorAttribute($request->lessor);
        $user->setLesseeAttribute($request->lessee);
        $user->setAdminAttribute($request->admin);
        $user->setClientAttribute($request->client);
        if (!empty($request->file('cover'))) {
            Storage::delete($user->cover);
            Cropper::flush($user->cover);
            $user->cover = '';
        }
        $user->fill($request->all());
        if (!empty($request->file('cover'))) {
            $user->cover = $request->file('cover')
                    ->storeAs('user', Str::slug($request->name) . '-' . str_replace('.', '', microtime(true)) . '.' . $request->file('cover')
                    ->extension());
        }
        if (!$user->save()) {
            return redirect()->back()->withInput()->withErrors();
        }
        $rolesRequest = $request->all();
        $roles = null;
        foreach ($rolesRequest as $key => $value) {
            if (Str::is('acl_*', $key) == true) {
                $roles[] = Role::where('id', ltrim($key, 'acl_'))->first();
            }
        }
        if (!empty($roles)) {
            $user->syncRoles($roles);
        } else if (Auth::user()->hasPermissionTo('Atribuir Permissões')) {
            $user->syncRoles(null);
        }
        return redirect()->route('admin.users.edit', [
                    'user' => $user->id
                ])->with(['message' => 'Cliente atualizado com sucesso!', 'type' => 'success', 'icon' => 'check']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if (!Auth::user()->hasPermissionTo('Remover Usuários')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        if (Auth::user()->id == $id) {
            return redirect()->route('admin.users.index')
                            ->with(['message' => 'Exclusão não realizada! Por segurança, você não pode excluir seu usuário.',
                                'type' => 'warning', 'icon' => 'exclamation-triangle']);
        }
        $user = User::where('id', $id)->first();
        if (empty($user->id)) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')
                        ->with(['message' => 'Usuário excluído com sucesso!', 'type' => 'success', 'icon' => 'trash']);
    }

}
