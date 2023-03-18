@extends('admin.master.master')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="icon-home"></i>Imóveis</h1>
            </div><!-- /.col -->
            <div class="col-sm-6 d-flex justify-content-end">
                <ol class="breadcrumb  my-auto">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Imóveis</li>
                </ol>
                @can('Cadastrar Imóveis')
                <a href="{{ route('admin.properties.create') }}" class="btn btn bg-gradient-lightblue icon-plus ml-1">Criar Imóvel</a>
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
                        <h5 class="card-title text-white"><i class="icon-home"></i>Imóveis Cadastrados</h5>
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
                                                                    <span class="info-box-text text-muted text-sm">Dromitórios: {{ $property->bedrooms + $property->suites }} quartos<br><span>sendo {{ $property->suites }} suítes</span>
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
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
</section>

@endsection