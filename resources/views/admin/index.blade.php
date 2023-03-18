<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="{{ url(mix('backend/assets/css/reset.css')) }}"/>
        <link rel="stylesheet" href="{{ url(mix('backend/assets/css/boot.css')) }}"/>
        <link rel="stylesheet" href="{{ url(mix('backend/assets/css/login.css')) }}"/>
        <link rel="icon" type="image/png" href="{{ url(asset('backend/assets/images/logo.svg')) }}"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ env('APP_NAME') }} :: Administração</title>
    </head>
    <body>

        <div class="ajax_response"></div>

        <div class="dash_login">
            <div class="dash_login_left">
                <article class="dash_login_left_box radius">
                    <header class="dash_login_box_headline">
                        <div class="dash_login_box_headline_logo mb-0 ">
                            <h1 class="d-none">Imob 2.0.0</h1>
                            <img src="{{ url(asset('backend/assets/images/brand.svg')) }}" width="">
                        </div>
                    </header>

                    <form name="login" action="{{ route('admin.login.do') }}" method="post" autocomplete="off">
                        <label>
                            <span class="field icon-envelope"></span>
                            <input type="email" name="email" placeholder="Informe seu e-mail" required class="input-form"/>
                        </label>

                        <label>
                            <span class="field icon-unlock-alt"></span>
                            <input type="password" name="password_check" placeholder="Informe sua senha" required/>
                        </label>

                        <button class="gradient gradient-theme radius text-opposit icon-sign-in">Entrar</button>
                    </form>

                    <footer class="text-support">
                        <p class="text-bold">Desenvolvido por <a href="https://www.rodrigobrito.dev.br" class="text-theme">www.<b>rodrigobrito</b>.dev.br</a></p>
                        <p class="text-bold">&copy; <?= date("Y"); ?> - Todos os direitos reservados</p>
                        <p class="dash_login_left_box_support">
                            <a target="_blank"
                               class="icon-whatsapp transition text-bold text-theme"
                               href="https://api.whatsapp.com/send?phone=55+021+99224-7968&text=Olá, preciso de ajuda com o login."
                               >Precisa de Suporte?</a>
                        </p>
                    </footer>
                </article>
            </div>

            <div class="dash_login_right"></div>

        </div>

        <script src="{{ url(mix('backend/assets/js/jquery.js')) }}"></script>
        <script src="{{ url(mix('backend/assets/js/login.js')) }}"></script>

    </body>
</html>
