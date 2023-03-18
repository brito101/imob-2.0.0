@extends('admin.master.master')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="icon-lock"></i>Permissões para: {{ $role->name }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6 d-flex justify-content-end">
                <ol class="breadcrumb  my-auto">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.role.index') }}">Perfis</a></li>
                    <li class="breadcrumb-item active">Editar Perfil</li>
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
                        <h5 class="card-title text-white"><i class="icon-pencil-square-o"></i>Dados do Perfil</h5>
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
                            <h3 class="mb-2 text-sm text-muted">Selecione as permissões para esse perfil:</h3>

                            <form action="{{ route('admin.role.permissionsSync', ['role' => $role->id]) }}" method="post" class="app_form" autocomplete="off">
                                @csrf
                                @method('PUT')

                                @foreach($permissions as $permission)
                                <div class="label">
                                    <label class="label">
                                        <input type="checkbox" id="{{ $permission->id }}" name="{{ $permission->id }}" {{ ($permission->can == '1' ? 'checked' : '') }}>
                                        <span class="text-muted">{{ $permission->name }}</span>
                                    </label>
                                </div>
                                @endforeach

                                <div class="text-right mt-2">
                                    <button class="btn btn-large bg-gradient-green" type="submit"><i class="icon-download"></i>Sincronizar Perfil
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
