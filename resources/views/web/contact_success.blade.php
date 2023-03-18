@extends('web.master.master')

@section('content')

<div class="container p-5">
    <h2 class="text-center text-support">Seu e-mail foi enviado com sucesso!<br>Em breve entraremos em contato.</h2>
    <div class="d-flex justify-content-center pt-4">
        <div class="text-center btn-custom w-md-25">
            <a href="{{ url()->previous() }}" class="text-opposit text-decoration-none">... Continuar navegando!</a>
        </div>
    </div>
</div>

@endsection
