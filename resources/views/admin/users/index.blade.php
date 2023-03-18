@extends('admin.master.master')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="icon-users"></i>Usuários</h1>
            </div><!-- /.col -->
            <div class="col-sm-6 d-flex justify-content-end">
                <ol class="breadcrumb  my-auto">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Clientes</li>
                </ol>
                @can('Cadastrar Usuários')
                <a href="{{ route('admin.users.create') }}" class="btn btn bg-gradient-lightblue icon-plus ml-1">Criar Usuários</a>
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
                        <h5 class="card-title text-white"><i class="icon-users"></i>Usuários Cadastrados</h5>
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
                                        <table id="dataTable" class="nowrap stripe" width="100" style="width: 100% !important;">
                                            <thead class="text-lightblue">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nome Completo</th>
                                                    <th>CPF</th>
                                                    <th>E-mail</th>
                                                    <th>Nascimento</th>
                                                    @can('Remover Usuários')
                                                    <th>Ações</th>
                                                    @endcan
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($users as $user)
                                                <tr>
                                                    <td><span class="badge bg-gradient-lightblue px-2">{{ $user->id }}</span></td>
                                                    @can('Editar Usuários')
                                                    <td title="Editar Usuário"><a href="{{ route('admin.users.edit', ['user' => $user->id]) }}" class="text-primary bold">{{ $user->name }}</a></td>
                                                    @else
                                                    <td title="Editar Usuário" class="text-muted bold">{{ $user->name }}</td>
                                                    @endcan
                                                    <td class="text-muted">{{ $user->document }}</td>
                                                    <td title="Encaminhar E-mail"><a href="mailto: {{ $user->email }}" class="text-primary bold">{{ $user->email }}</a></td>
                                                    <td class="text-muted">{{ $user->date_of_birth }}</td>
                                                    @can('Remover Usuários')
                                                    <td class="text-center">
                                                        <form action="{{ route('admin.users.destroy', ['user' => $user->id]) }}" method="post">
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
