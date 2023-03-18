<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Company as CompanyRequest;
use App\Models\User;
use App\Models\Company;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (!Auth::user()->hasPermissionTo('Listar Empresas')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $companies = Company::all();
        return view('admin.companies.index', [
            'companies' => $companies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        if (!Auth::user()->hasPermissionTo('Cadastrar Empresas')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $users = User::orderBy('name')->get();
        if (!empty($request->user)) {
            $user = User::where('id', $request->user)->first();
        }
        return view('admin.companies.create', [
            'users' => $users,
            'selected' => (!empty($user) ? $user : null)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request) {
        if (!Auth::user()->hasPermissionTo('Cadastrar Empresas')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $createCompany = Company::create($request->all());
        return redirect()->route('admin.companies.edit', [
                    'company' => $createCompany->id,
                ])->with(['message' => 'Empresa criada com sucesso!', 'type' => 'success', 'icon' => 'check']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        if (!Auth::user()->hasPermissionTo('Editar Empresas')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $company = Company::where('id', $id)->first();
        if (empty($company->id)) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $users = User::orderBy('name')->get();
        return view('admin.companies.edit', [
            'company' => $company,
            'users' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, $id) {
        if (!Auth::user()->hasPermissionTo('Editar Empresas')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $company = Company::where('id', $id)->first();
        if (empty($company->id)) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $company->fill($request->all());
        $company->save();
        return redirect()->route('admin.companies.edit', [
                    'company' => $company->id,
                ])->with(['message' => 'Empresa atualizada com sucesso!', 'type' => 'success', 'icon' => 'check']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if (!Auth::user()->hasPermissionTo('Remover Empresas')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $company = Company::where('id', $id)->first();
        if (empty($company->id)) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $company->delete();
        return redirect()->route('admin.companies.index')
                        ->with(['message' => 'Empresa excluída com sucesso!', 'type' => 'success', 'icon' => 'trash']);
    }

}
