@extends('admin.master.master')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="icon-building"></i>Empresas</h1>
            </div><!-- /.col -->
            <div class="col-sm-6 d-flex justify-content-end">
                <ol class="breadcrumb  my-auto">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Clientes</a></li>
                    <li class="breadcrumb-item active">Empresas</li>
                </ol>
                @can('Cadastrar Empresas')
                <a href="{{ route('admin.companies.create') }}" class="btn btn bg-gradient-lightblue icon-plus ml-1">Criar Empresa</a>
                @endcan
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
@if($errors->all())
@foreach($errors->all() as $error)
<x-alert type="danger" icon="icon-exclamation-triangle" :message="$error"/>
@endforeach
@endif

@if(session()->exists('message'))
<x-alert type="{{ session()->get('type') }}" icon="icon-{{ session()->get('icon') }}" message="{{ session()->get('message') }}"/>
@endif
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-gradient-dark">
                        <h5 class="card-title text-white"><i class="icon-building"></i>Empresas Cadastradas</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool text-white" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="dash_content_app_box">
                                    <div class="dash_content_app_box_stage">
                                        <table id="dataTable" class="nowrap hover stripe" width="100" style="width: 100% !important;">
                                            <thead class="text-lightblue">
                                                <tr>
                                                    <th>Razão Social</th>
                                                    <th>Nome Fantasia</th>
                                                    <th>CNPJ</th>
                                                    <th>IE</th>
                                                    <th>Responsável</th>
                                                    @can('Remover Empresas')
                                                    <th>Ações</th>
                                                    @endcan
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($companies as $company)
                                                <tr>
                                                    <td title="Editar Empresa">
                                                        @can('Editar Empresas')
                                                        <a href="{{ route('admin.companies.edit', ['company' => $company->id]) }}" class="text-primary bold">{{ $company->social_name }}</a>
                                                        @else
                                                        <span class="text-muted">{{ $company->social_name }}</span>
                                                        @endcan
                                                    </td>
                                                    <td>{{ $company->alias_name }}</td>
                                                    <td>{{ $company->document_company }}</td>
                                                    <td>{{ $company->document_company_secondary }}</td>
                                                    <td title="Editar Usuário">
                                                        @can('Editar Usuários')
                                                        <a href="{{ route('admin.users.edit', ['user' => $company->owner()->first()->id]) }}" class="text-primary bold">{{ $company->owner()->first()->name }}</a>
                                                        @else
                                                        <span class="text-muted">{{ $company->owner()->first()->name }}</span>
                                                        @endcan
                                                    </td>
                                                    @can('Remover Empresas')
                                                    <td>
                                                        <form action="{{ route('admin.companies.destroy', ['company' => $company->id]) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <input class="btn btn-sm bg-gradient-danger text-sm" type="submit" value="Remover">
                                                        </form>
                                                    </td>
                                                    @endcan
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </div>
</section>

@endsection