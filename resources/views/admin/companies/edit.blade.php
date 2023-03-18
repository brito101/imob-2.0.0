@extends('admin.master.master')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="icon-building"></i>Edição de Empresa</h1>
            </div><!-- /.col -->
            <div class="col-sm-6 d-flex justify-content-end">
                <ol class="breadcrumb  my-auto">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Clientes</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.companies.index') }}">Empresas</a></li>
                    <li class="breadcrumb-item active">Editar Empresa</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

@if($errors->all())
@foreach($errors->all() as $error)
<x-alert type="danger" icon="icon-exclamation-triangle" :message="$error"/>
@endforeach
@endif

@if(session()->exists('message'))
<x-alert type="{{ session()->get('type') }}" icon="icon-{{ session()->get('icon') }}" message="{{ session()->get('message') }}"/>
@endif

<section class="content">
    <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-gradient-dark">
                        <h5 class="card-title text-white"><i class="icon-building-o"></i>Dados da Empresa</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool text-white" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>    

                    <div class="dash_content_app_box">
                        <div class="dash_content_app_box_stage m-2">
                            <form class="app_form" action="{{ route('admin.companies.update', ['company' => $company]) }}" method="post">
                                @csrf
                                @method('PUT')
                                <label class="label">
                                    <span class="legend">Responsável Legal:</span>
                                    <select name="user" class="select2">
                                        <option value="" selected>Selecione um responsável legal</option>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}" @if(old('user') == $user->id) {{'selected'}} @else {{ ($user->id == $company->user ? 'selected' : '') }} @endif>{{ $user->name }} ({{ $user->document }})</option>
                                        @endforeach
                                    </select>
                                    @can('Editar Usuários')
                                    <p style="margin-top: 4px;">
                                        <a href="{{ route('admin.users.edit', ['user' => $company->user]) }}" class="text-primary bold icon-link" style="font-size: .8em;" target="_blank">Acessar
                                            Cadastro</a>
                                    </p>
                                    @endcan
                                </label>

                                <label class="label">
                                    <span class="legend">*Razão Social:</span>
                                    <input type="text" name="social_name" placeholder="Razão Social" value="{{ old('social_name') ?? $company->social_name }}"/>
                                </label>

                                <label class="label">
                                    <span class="legend">Nome Fantasia:</span>
                                    <input type="text" name="alias_name" placeholder="Nome Fantasia" value="{{ old('alias_name') ?? $company->alias_name }}"/>
                                </label>

                                <div class="label_g2">
                                    <label class="label">
                                        <span class="legend">CNPJ:</span>
                                        <input type="tel" name="document_company" class="mask-cnpj" placeholder="CNPJ da Empresa"
                                               value="{{ old('document_company') ?? $company->document_company }}"/>
                                    </label>

                                    <label class="label">
                                        <span class="legend">Inscrição Estadual:</span>
                                        <input type="text" name="document_company_secondary" placeholder="Número da Inscrição"
                                               value="{{ old('document_company_secondary') ?? $company->document_company_secondary }}"/>
                                    </label>
                                </div>

                                <div class="app_collapse">
                                    <div class="app_collapse_header mt-2 collapse">
                                        <h3>Endereço</h3>
                                        <span class="icon-minus-circle icon-notext"></span>
                                    </div>

                                    <div class="app_collapse_content">
                                        <div class="label_g2">
                                            <label class="label">
                                                <span class="legend">*CEP:</span>
                                                <input type="tel" name="zipcode" class="mask-zipcode zip_code_search"
                                                       placeholder="Digite o CEP" value="{{ old('zipcode') ?? $company->zipcode }}"/>
                                            </label>
                                        </div>

                                        <label class="label">
                                            <span class="legend">*Endereço:</span>
                                            <input type="text" name="street" class="street" placeholder="Endereço Completo" value="{{ old('street') ?? $company->street }}"/>
                                        </label>

                                        <div class="label_g2">
                                            <label class="label">
                                                <span class="legend">*Número:</span>
                                                <input type="text" name="number" placeholder="Número do Endereço" value="{{ old('number') ?? $company->number }}"/>
                                            </label>

                                            <label class="label">
                                                <span class="legend">Complemento:</span>
                                                <input type="text" name="complement" placeholder="Completo (Opcional)" value="{{ old('complement') ?? $company->complement }}"/>
                                            </label>
                                        </div>

                                        <label class="label">
                                            <span class="legend">*Bairro:</span>
                                            <input type="text" name="neighborhood" class="neighborhood" placeholder="Bairro" value="{{ old('neighborhood') ?? $company->neighborhood }}"/>
                                        </label>

                                        <div class="label_g2">
                                            <label class="label">
                                                <span class="legend">*Estado:</span>
                                                <input type="text" name="state" class="state" placeholder="Estado" value="{{ old('state') ?? $company->state }}"/>
                                            </label>

                                            <label class="label">
                                                <span class="legend">*Cidade:</span>
                                                <input type="text" name="city" class="city" placeholder="Cidade" value="{{ old('city') ?? $company->city }}"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right mt-2">
                                    <button class="btn btn-large bg-gradient-green" type="submit"><i class="icon-check-square-o"></i>Salvar Alterações
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection