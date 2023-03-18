<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        {!! $head ?? '' !!}

        <link rel="stylesheet" href="{{ url(asset('frontend/assets/css/bootstrap.css')) }}">
        <link rel="stylesheet" href="{{ url(asset('frontend/assets/libs/libs.css')) }}">
        <link rel="stylesheet" href="{{ url(asset('frontend/assets/css/app.css')) }}" >

        @hasSection('css')
        @yield('css')
        @endif

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ url(asset('frontend/assets/images/logo.svg')) }}"/>

        @if (Cookie::get(env('COOKIE_CONSENT_NAME')) == '1')
        @include('cookieConsent::gtm-head')
        @endif

    </head>
    <body>

        @include('cookieConsent::index')

        @if (Cookie::get(env('COOKIE_CONSENT_NAME')) == '1')
        @include('cookieConsent::gtm-body')
        @endif

        <header class="main_header">
            <div class="header_bar">
                <div class="container">
                    <div class="row py-1 d-flex justify-content-md-around">

                        <div class="d-none d-lg-flex col-lg-4 justify-content-center align-items-center p-2 text-opposit">
                            <i class="icon-map-marker"></i>
                            {{ Cookie::get('imob-2.0.0=1') }}
                            <p class="my-auto ml-3">Rua Gen. Miguel Ferreira, 0 - Taquara<br/>Rio de Janeiro-RJ</p>
                        </div>

                        <div class="d-none d-md-flex col-md-6 col-lg-4 justify-content-center align-items-center p-2 text-opposit">
                            <i class="icon-clock-o"></i>
                            <p class="my-auto ml-3">Seg/Sex: 09:00h - 18:00h<br/>Sáb/Dom: Plantão</p>
                        </div>

                        <div class="d-flex col-12 col-md-6 col-lg-4 justify-content-center align-items-center p-2 mx-auto text-opposit">
                            <i class="icon-envelope"></i>
                            <p class="my-auto ml-3">contato@rodrigobrito.dev.br<br/>+55 (21) 99224-7968</p>
                        </div>

                    </div>
                </div>
            </div>

            <nav class="navbar navbar-expand-md navbar-light my-3">
                <div class="container">

                    <div class="navbar-brand">
                        <a href="{{ route('web.home') }}" class="d-flex justify-content-center align-items-center text-decoration-none">
                            <h1 class="text-hide">Imob 2.0.0</h1>
                            <img src="{{ url(asset('frontend/assets/images/brand.svg')) }}" alt="Imob 2.0.0" class="brand-image-custom">
                        </a>
                    </div>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Menu Principal">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-end" id="navbar">
                        <ul class="navbar-nav">
                            <li class="nav-item"><a href="{{ route('web.home') }}" class="nav-link text-support">Home</a></li>
                            <li class="nav-item"><a href="{{ route('web.buy') }}" class="nav-link text-support">Comprar</a></li>
                            <li class="nav-item"><a href="{{ route('web.rent') }}" class="nav-link text-support">Alugar</a></li>
                            <li class="nav-item"><a href="{{ route('web.spotlight') }}" class="nav-link text-front">Destaque</a></li>
                            <li class="nav-item"><a href="{{ route('web.contact') }}" class="nav-link text-support">Contato</a></li>
                        </ul>
                    </div>

                </div>
            </nav>
        </header>

        @yield('content')

        <article class="main_optin bg-support text-white py-5">
            <div class="container">
                <div class="row mx-auto" style="max-width: 600px;">
                    <h1>Quer ficar por dentro da novidades?</h1>

                    <p>Deixe o seu nome e seu melhor e-mail nos campos abaixo e nós vamos lhe informar sobre os melhores
                        negócios e todos os lançamentos do Rio de Janeiros</p>

                    <form action="{{ route('web.sendEmail') }}" method="post" autocomplete="off">
                        @csrf
                        <input type="text" class="form-control" name="name" placeholder="Digite seu nome" size="50" required>
                        <input type="email" class="form-control" name="email" placeholder="Digite seu melhor e-mail" size="50" required>
                        <input class="d-none" name="message" value="Quero receber notícias de lançamentos e novidades">
                        <button type="submit" class="btn-custom text-opposit shadow-sm">Me avise!</button>
                    </form>
                </div>
            </div>
        </article>

        <section class="main_footer bg-light"
                 style="background: url({{ asset('frontend/assets/images/footer.png') }}) repeat-x bottom center; background-size: 10%;">
            <div class="container pt-5" style="padding-bottom: 120px;">

                <div class="row d-flex justify-content-around text-muted">

                    <div class="col-12 col-md-3 col-lg-3">
                        <h1 class="pb-2">Navegue <span class="text-front">Aqui!</span></h1>
                        <ul>
                            <li><a href="{{ route('web.home') }}" class="text-back text-decoration-none">Home</a></li>
                            <li><a href="{{ route('web.buy') }}" class="text-back text-decoration-none">Comprar</a></li>
                            <li><a href="{{ route('web.rent') }}" class="text-back text-decoration-none">Alugar</a></li>
                            <li><a href="{{ route('web.spotlight') }}" class="text-front text-decoration-none">Destaque</a></li>
                            <li><a href="{{ route('web.contact') }}" class="text-back text-decoration-none">Contato</a></li>
                            <li><a href="{{ route('web.policy') }}" class="text-back text-decoration-none">Política de Privacidade</a></li>
                        </ul>
                    </div>

                    <div class="col-12 col-md-9 col-lg-6">
                        <h1 class="pb-2">Nos <span class="text-front">Conheça!</span></h1>
                        <p>Nossa maior satisfação é lhe ajudar a encontrar seu imóvel dos sonhos nos bairros do Sul da Ilha da
                            Magia, em Florianópolis.</p>

                        <h1 class="pb-2">Quer <span class="text-front">Investir?</span></h1>
                        <p>Entre em contato com a nossa equipe e vamos lhe informar sempre sobre os melhores negócios.</p>
                    </div>

                    <div class="col-12 col-md-12 col-lg-3 text-center">
                        <a href="{{ env("CLIENT_DATA_LINK_FACEBOOK") }}" target="_blank" class="btn-custom text-opposit icon-facebook icon-notext"></a>
                        <a href="{{ env("CLIENT_DATA_LINK_TWITTER") }}" target="_blank" class="btn-custom text-opposit icon-twitter icon-notext"></a>
                        <a href="{{ env("CLIENT_DATA_LINK_INSTAGRAM") }}" target="_blank" class="btn-custom text-opposit icon-instagram icon-notext"></a>
                    </div>
                </div>
            </div>
        </section>

        <div class="main_copyright py-3 text-opposit text-center">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <p class="mb-0">CRECI: RJ 000000/F | CNPJ: 00.000.000/0000-00 | Rio de Janeiro-RJ</p>
                        <p class="mb-0">Todos os Direitos Reservados - {{ env('APP_NAME') }} ®</p>
                        <p class="mb-0">Desenvolvido com <i class="icon-heart text-back"></i>por
                            <a href="https://www.rodrigobrito.dev.br" target="_blank" class="text-white text-decoration-none">
                                Rodrigo Brito</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ url(asset('frontend/assets/js/jquery.js')) }}"></script>
        <script src="{{ url(asset('frontend/assets/js/bootstrap.js')) }}"></script>
        <script src="{{ url(asset('frontend/assets/js/libs.js')) }}"></script>
        <script src="{{ url(asset('frontend/assets/libs/libs.js')) }}"></script>
        <script src="{{ url(asset('frontend/assets/js/scripts.js')) }}"></script>

        @hasSection('js')
        @yield('js')
        @endif

    </body>
</html>