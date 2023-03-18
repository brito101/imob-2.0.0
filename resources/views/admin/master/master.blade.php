<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0">
    <link rel="stylesheet" href="{{ url(asset('vendor/fontawesome-free/css/all.min.css')) }}" />
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/reset.css')) }}" />
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/boot.css')) }}" />
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/style.css')) }}" />
    <link rel="stylesheet" href="{{ url(asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css')) }}" />
    <link rel="stylesheet" href="{{ url(asset('vendor/adminlte/dist/css/adminlte.min.css')) }}" />
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/libs.css')) }}" />
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/complement.css')) }}" />

    @hasSection('css')
        @yield('css')
    @endif

    <link rel="icon" type="image/png" href="{{ url(asset('backend/assets/images/logo.svg')) }}" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }} :: Administrativo</title>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="ajax_load">
        <div class="ajax_load_box">
            <div class="ajax_load_box_circle"></div>
            <p class="ajax_load_box_title">Aguarde, carregando...</p>
        </div>
    </div>
    <div class="ajax_response"></div>
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('admin.home') }}" class="nav-link">Home</a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-danger elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('admin.home') }}" class="brand-link">
                <img src="{{ url(asset('backend/assets/images/logo.svg')) }}" alt="{{ env('APP_NAME') }}"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @php
                            if (\Illuminate\Support\Facades\Auth::user()->url_cover != '') {
                                $cover = \Illuminate\Support\Facades\Auth::user()->url_cover;
                            } else {
                                $cover = url(asset('backend/assets/images/avatar.jpg'));
                            }
                        @endphp
                        <img src="{{ $cover }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        @can('Editar Usuários')
                            <a href="{{ route('admin.users.edit', ['user' => \Illuminate\Support\Facades\Auth::user()->id]) }}"
                                class="d-block">
                                {{ \Illuminate\Support\Facades\Auth::user()->name }}</a>
                        @else
                            <span class="text-white">{{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
                        @endcan
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item menu-open">
                            <a href="{{ route('admin.home') }}" class="nav-link {{ isActive('admin.home') }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        @can('Listar Usuários')
                            {{-- Menu Usuários --}}
                            <li
                                class="nav-item has-treeview {{ menuOpen('admin.users') }} {{ menuOpen('admin.companies') }}">
                                <a href="#"
                                    class="nav-link {{ isActive('admin.users') }}  {{ isActive('admin.companies') }}"><i
                                        class="nav-icon fas fa-users"></i>
                                    <p>Usuários<i class="fas fa-angle-left right"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('Listar Usuários')
                                        <li class="nav-item"><a href="{{ route('admin.users.index') }}"
                                                class="nav-link {{ isActive('admin.users.index') }}"><i
                                                    class="far fa-circle nav-icon"></i>
                                                <p>Ver Todos</p>
                                            </a></li>
                                    @endcan
                                    @can('Listar Empresas')
                                        <li class="nav-item"><a href="{{ route('admin.companies.index') }}"
                                                class="nav-link {{ isActive('admin.companies.index') }}"><i
                                                    class="far fa-circle nav-icon"></i>
                                                <p>Empresas</p>
                                            </a></li>
                                    @endcan
                                    @can('Listar Usuários - Equipe')
                                        <li class="nav-item"><a href="{{ route('admin.users.team') }}"
                                                class="nav-link {{ isActive('admin.users.team') }}"><i
                                                    class="far fa-circle nav-icon"></i>
                                                <p>Time</p>
                                            </a></li>
                                    @endcan
                                    @can('Cadastrar Usuários')
                                        <li class="nav-item"><a href="{{ route('admin.users.create') }}"
                                                class="nav-link {{ isActive('admin.users.create') }}"><i
                                                    class="far fa-circle nav-icon"></i>
                                                <p>Criar Novo</p>
                                            </a></li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan

                        @can('Listar Imóveis')
                            {{-- Menu Imóveis --}}
                            <li class="nav-item has-treeview {{ menuOpen('admin.properties') }}">
                                <a href="#" class="nav-link {{ isActive('admin.properties') }}"><i
                                        class="nav-icon fas fa-home"></i>
                                    <p>Imóveis<i class="fas fa-angle-left right"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('Listar Imóveis')
                                        <li class="nav-item"><a href="{{ route('admin.properties.index') }}"
                                                class="nav-link {{ isActive('admin.properties.index') }}"><i
                                                    class="far fa-circle nav-icon"></i>
                                                <p>Ver Todos</p>
                                            </a></li>
                                    @endcan
                                    @can('Cadastrar Imóveis')
                                        <li class="nav-item"><a href="{{ route('admin.properties.create') }}"
                                                class="nav-link  {{ isActive('admin.properties.create') }}"><i
                                                    class="far fa-circle nav-icon"></i>
                                                <p>Criar Novo</p>
                                            </a></li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan

                        @can('Listar Contratos')
                            {{-- Menu Contratos --}}
                            <li class="nav-item has-treeview {{ menuOpen('admin.contracts') }}">
                                <a href="#" class="nav-link  {{ isActive('admin.contracts') }}"><i
                                        class="nav-icon icon-file-text"></i>
                                    <p>Contratos<i class="fas fa-angle-left right"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('Listar Contratos')
                                        <li class="nav-item"><a href="{{ route('admin.contracts.index') }}"
                                                class="nav-link {{ isActive('admin.contracts.index') }}"><i
                                                    class="far fa-circle nav-icon"></i>
                                                <p>Ver Todos</p>
                                            </a></li>
                                    @endcan
                                    @can('Cadastrar Contratos')
                                        <li class="nav-item"><a href="{{ route('admin.contracts.create') }}"
                                                class="nav-link {{ isActive('admin.contracts.create') }}"><i
                                                    class="far fa-circle nav-icon"></i>
                                                <p>Criar Novo</p>
                                            </a></li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan

                        @can(['Listar Perfis', 'Listar Permissões'])
                            {{-- Menu ACL --}}
                            <li
                                class="nav-item has-treeview {{ menuOpen('admin.role') }} {{ menuOpen('admin.permission') }}">
                                <a href="#"
                                    class="nav-link {{ isActive('admin.role') }}  {{ isActive('admin.permission') }}"><i
                                        class="nav-icon fas fa-shield-alt"></i>
                                    <p>ACL<i class="fas fa-angle-left right"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('Listar Perfis')
                                        <li class="nav-item"><a href="{{ route('admin.role.index') }}"
                                                class="nav-link {{ isActive('admin.role.index') }}"><i
                                                    class="far fa-circle nav-icon"></i>
                                                <p>Perfis</p>
                                            </a></li>
                                    @endcan
                                    @can('Listar Permissões')
                                        <li class="nav-item"><a href="{{ route('admin.permission.index') }}"
                                                class="nav-link {{ isActive('admin.permission.index') }}"><i
                                                    class="far fa-circle nav-icon"></i>
                                                <p>Permissões</p>
                                            </a></li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan

                        <li class="nav-item">
                            <a href="{{ env('APP_URL') }}" target="_blank" class="nav-link"><i
                                    class="nav-icon fas fa-link text-green"></i>
                                <p class="text">Ver Site</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.logout') }}" class="nav-link"><i
                                    class="nav-icon fas fa-sign-out-alt text-danger"></i>
                                <p class="text">Sair</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- Main Footer -->
        <footer class="main-footer text-sm">
            <strong>Copyright &copy; 2021-<?= date('Y') ?> :: <a href="https://www.rodrigobrito.dev.br"
                    target="_blank">Rodrigo Brito</a>.</strong>
            Todos os direitos reservados
            <div class="float-right d-none d-sm-inline-block">
                <b>Versão</b> 1.0.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->
    <script src="{{ url(mix('backend/assets/js/jquery.js')) }}"></script>
    <script src="{{ url(asset('backend/assets/js/tinymce/tinymce.min.js')) }}"></script>
    <script src="{{ url(mix('backend/assets/js/libs.js')) }}"></script>
    <script src="{{ url(mix('backend/assets/js/scripts.js')) }}"></script>
    <script src="{{ url(mix('backend/assets/js/bootstrap.js')) }}"></script>
    <script src="{{ url(asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js')) }}"></script>
    <script src="{{ url(asset('vendor/adminlte/dist/js/adminlte.js')) }}"></script>

    @hasSection('js')
        @yield('js')
    @endif

</body>

</html>
