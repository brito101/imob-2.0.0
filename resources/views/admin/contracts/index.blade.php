@extends('admin.master.master')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="icon-file-text"></i>Contratos</h1>
            </div><!-- /.col -->
            <div class="col-sm-6 d-flex justify-content-end">
                <ol class="breadcrumb  my-auto">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Contratos</li>
                </ol>
                @can('Cadastrar Contratos')
                <a href="{{ route('admin.contracts.create') }}" class="btn btn bg-gradient-lightblue icon-plus ml-1">Criar Contrato</a>
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
                        <h5 class="card-title text-white"><i class="icon-file-text"></i>Listagem de Contratos</h5>
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
                                                    <th>#</th>
                                                    <th>Locador</th>
                                                    <th>Locatário</th>
                                                    <th>Negócio</th>
                                                    <th>Início</th>
                                                    <th>Vigência</th>
                                                    @can('Remover Contratos')
                                                    <th>Ações</th>
                                                    @endcan
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($contracts as $contract)
                                                <tr>
                                                    @can('Editar Contratos')
                                                    <td title="Editar Contrato">
                                                        <a href="{{ route('admin.contracts.edit', ['contract' => $contract->id]) }}" class="text-primary bold">
                                                            <span class="badge bg-gradient-lightblue px-2">{{ $contract->id }}</span></a>
                                                    </td>
                                                    @else
                                                    <td title="Editar Contrato">
                                                        <span class="badge bg-gradient-lightblue px-2">{{ $contract->id }}</span>
                                                    </td>
                                                    @endcan
                                                    @can('Editar Usuários')
                                                    <td title="Editar Usuário"><a href="{{ route('admin.users.edit', ['user' => $contract->ownerObject->id ]) }}" class="text-primary bold">
                                                            {{ $contract->ownerObject->name }}</a></td>
                                                    @else
                                                    <td title="Editar Usuário" class="text-muted">{{ $contract->ownerObject->name }}</td>
                                                    @endcan
                                                    @can('Editar Usuários')
                                                    <td title="Editar Usuário"><a href="{{ route('admin.users.edit', ['user' => $contract->acquirerObject->id ]) }}" class="text-primary bold">
                                                            {{ $contract->acquirerObject->name }}</a></td>
                                                    @else
                                                    <td title="Editar Usuário" class="text-muted">{{ $contract->acquirerObject->name }}</td>
                                                    @endcan
                                                    <td class="text-muted">{{ ($contract->sale == true ? 'Venda' : 'Locação') }}</td>
                                                    <td class="text-muted">{{ $contract->start_at }}</td>
                                                    <td class="text-muted">{{ $contract->deadline }} meses</td>
                                                    @can('Remover Contratos')
                                                    <td class="text-center">
                                                        <form action="{{ route('admin.contracts.destroy', ['contract' => $contract->id]) }}" method="post">
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