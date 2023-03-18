@extends('admin.master.master')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="icon-tachometer"></i>Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row text-muted text-sm">
            @can('Listar Usuários')
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content ml-2">
                        <span class="info-box-number text-dark">Clientes</span>
                        <span class="info-box-text">Time: {{ $team }}</span>
                        <span class="info-box-text">Locadores: {{ $lessors }}</span>
                        <span class="info-box-text">Locatários: {{ $lessees }}</span>
                        <span class="info-box-text">&nbsp;</span>
                    </div>
                </div>
            </div>
            @endcan
            @can('Listar Imóveis')
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-home"></i></span>
                    <div class="info-box-content ml-2">
                        <span class="info-box-number text-dark">Imóveis</span>
                        <span class="info-box-text">Total: {{ $propertiesAvailable }}</span>
                        <span class="info-box-text">Disponíveis: {{ $propertiesUnavailable }}</span>
                        <span class="info-box-text">Locados: {{ $propertiesTotal }}</span>
                        <span class="info-box-text">&nbsp;</span>
                    </div>
                </div>
            </div>
            @endcan
            @can('Listar Contratos')
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-file-alt"></i></span>
                    <div class="info-box-content ml-2">
                        <span class="info-box-number text-dark">Contratos</span>
                        <span class="info-box-text">Total: {{ $contractsTotal }}</span>
                        <span class="info-box-text">Pendentes: {{ $contractsPendent }}</span>
                        <span class="info-box-text">Ativos: {{ $contractsActive }}</span>
                        <span class="info-box-text">Cancelados: {{ $contractsCanceled }}</span>
                    </div>
                </div>
            </div>
            @endcan
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                @can('Listar Contratos')
                <div class="card">
                    <div class="card-header bg-gradient-dark">
                        <h5 class="card-title text-white"><i class="icon-file-text"></i>Últimos Contratos Cadastrados</h5>
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
                                                    <td title="Editar Contrato"><a href="{{ route('admin.contracts.edit', ['contract' => $contract->id]) }}" class="text-primary bold">
                                                            <span class="badge bg-gradient-lightblue px-2">{{ $contract->id }}</span></a></td>
                                                    @else
                                                    <td title="Editar Contrato"><span class="badge bg-gradient-lightblue px-2">{{ $contract->id }}</span></td>
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
                                                    <td title="Editar Usuário" class="text-muted"> {{ $contract->acquirerObject->name }}</td>
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
                @endcan
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                @can('Listar Imóveis')
                <div class="card">
                    <div class="card-header bg-gradient-dark">
                        <h5 class="card-title text-white"><i class="icon-home"></i>Últimos Imóveis Cadastrados</h5>
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
                                @if(!empty($properties))
                                @foreach($properties as $property)
                                <div class="card">
                                    <h5 class="card-header text-dark bg-gradient-light">
                                        <span class="badge bg-gradient-lightblue">#{{ $property->id }}</span> {{ $property->category }} - {{ $property->type }}
                                        @if($property->sale == true && !empty($property->sale_price))
                                        :: <span class="text-bold text-lightblue">Venda:</span> R$ {{ $property->sale_price }}
                                        @endif

                                        @if($property->rent == true && !empty($property->rent_price))
                                        :: <span class="text-bold text-lightblue">Aluguel:</span> R$ {{ $property->rent_price }}
                                        @endif
                                    </h5>
                                    <div class="card-body">
                                        <div class="card-deck">
                                            <div class="card col-md-4 mb-0 p-0">
                                                <img class="card-img-top w-100" src="{{ $property->cover() }}" alt="Card image cap">
                                                <div class="card-body">
                                                    <p class="card-text text-muted text-center"><i class="fa fa-chart-bar">&nbsp;</i><small>{{$property->views }} visualizações</small></p>
                                                </div>
                                            </div>

                                            <div class="card col-md-8 mb-0 p-0">                                                

                                                <div class="card-body pb-0">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-6 col-md-6">
                                                            <div class="info-box">
                                                                <span class="info-box-icon bg-light elevation-1"><i class="icon-realty-location"></i></span>
                                                                <div class="info-box-content ml-2">
                                                                    <span class="info-box-text text-muted text-sm">Bairro: {{ $property->neighborhood }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6 col-md-6">
                                                            <div class="info-box">
                                                                <span class="info-box-icon bg-light elevation-1"><i class="icon-realty-util-area"></i></span>
                                                                <div class="info-box-content ml-2">
                                                                    <span class="info-box-text text-muted text-sm">Área Útil: {{ $property->area_util }}m&sup2;</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6 col-md-6">
                                                            <div class="info-box">
                                                                <span class="info-box-icon bg-light elevation-1"><i class="icon-realty-bed"></i></span>
                                                                <div class="info-box-content ml-2">
                                                                    <span class="info-box-text text-muted text-sm">Dormitórios: {{ $property->bedrooms + $property->suites }} quartos<br><span>sendo {{ $property->suites }} suítes</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6 col-md-6">
                                                            <div class="info-box">
                                                                <span class="info-box-icon bg-light elevation-1"><i class="icon-realty-garage"></i></span>
                                                                <div class="info-box-content ml-2">
                                                                    <span class="info-box-text text-muted text-sm">Garagem: {{ $property->garage + $property->garage_covered }} vagas<br><span>sendo {{ $property->garage_covered }} cobertas</span>
                                                                </div>
                                                            </div>
                                                        </div>   
                                                    </div>
                                                </div>

                                                <div class="card-footer rounded mx-0 p-0">
                                                    <div class="btn-group-sm  text-center">
                                                        <div style="display: flex; flex-wrap: wrap; justify-content: center;">
                                                            @if($property->sale == true && !empty($property->sale_price))
                                                            <a href="{{ route('web.buyProperty', ['slug' => $property->slug]) }}"
                                                               class="btn btn-sm bg-info" target="_blank" style="width: 120px;">Ver Compra</a>
                                                            @endif
                                                            @if($property->rent == true && !empty($property->rent_price))
                                                            <a href="{{ route('web.rentProperty', ['slug' => $property->slug]) }}"
                                                               class="btn btn-sm  bg-info" target="_blank" style="width: 120px;">Ver Locação</a>
                                                            @endif
                                                            @can('Editar Imóveis')
                                                            <a href="{{ route('admin.properties.edit', ['property' => $property->id]) }}" class="btn btn-sm  bg-success" style="width: 120px;">Editar</a>
                                                            @endcan
                                                            @can('Remover Imóveis')
                                                            <form action="{{ route('admin.properties.destroy', ['property' => $property->id]) }}" method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <input class="btn btn-sm  bg-danger"  type="submit" value="Remover" style="width: 120px!important;">
                                                            </form>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="no-content">Não foram encontrados registros!</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
    </div>
</section>
@endsection
