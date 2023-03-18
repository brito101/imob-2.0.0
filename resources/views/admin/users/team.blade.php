@extends('admin.master.master')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="icon-users"></i>Time</h1>
            </div><!-- /.col -->
            <div class="col-sm-6 d-flex justify-content-end">
                <ol class="breadcrumb  my-auto">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>                    
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Clientes</a></li>
                    <li class="breadcrumb-item active">Time</li>
                </ol>
                <a href="#" class="btn btn bg-gradient-lightblue icon-plus ml-1">Criar Usuário</a>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-gradient-dark">
                        <h5 class="card-title text-white"><i class="icon-users"></i>Colaboradores Cadastrados</h5>
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

                                <div class="row">
                                    <!-- /.col -->
                                    @foreach($users as $user)
                                    <div class="col-md-4">
                                        <!-- Widget: user widget style 1 -->
                                        <div class="card card-widget widget-user">
                                            <!-- Add the bg color to the header using any of the bg-* classes -->
                                            <div class="widget-user-header bg-gradient-lightblue">
                                                <h5 class="widget-user-username">{{ $user->name }}</h5>
                                                <p class="widget-user-desc">{{ $user->email }}</p>
                                            </div>
                                            <div class="widget-user-image">
                                                @if(!empty($user->url_cover)) 
                                                <img class="img-circle elevation-2" src="{{ $user->url_cover }}" alt="{{ $user->name }}">
                                                @else
                                                <img class="img-circle elevation-2" src="{{ url('backend/assets/images/avatar.jpg')  }}" alt="{{ $user->name }}">
                                                @endif
                                            </div>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="description-block">
                                                            <p class="widget-user-desc text-sm text-muted">Desde: {{ $user->created_at? date('d/m/Y', strtotime($user->created_at)) : 'sem data de criação' }}</p>
                                                            <p class="widget-user-desc text-sm text-muted">Último acesso: {{ $user->last_login_at ? date('d/m/Y H:i:s', strtotime($user->last_login_at)) : 'inexistente' }}</p>
                                                            <a class="icon-cog btn bg-gradient-lightblue mt-3" href="{{ route('admin.users.edit', ['user' => $user->id]) }}" title="">Gerenciar</a>
                                                        </div>
                                                        <!-- /.description-block -->
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                        </div>
                                        <!-- /.widget-user -->
                                    </div>
                                    @endforeach
                                    <!-- /.col -->
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
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