

@extends('layouts.base')

@section('styles')
<link href="{{ asset('css/login/css/login.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

@endsection

@section('title', 'Ingreso')

@section('content')




<form method="POST" class="form" action="{{  route('login') }}">
    @csrf 
    <h2>Iniciar sesión</h2>
    <div class="content-login">
        <div class="input-content">
            <input type="text" name="email" placeholder="Correo eléctronico" value=" {{ old('email') }}" autofocus>

            @error('email')
            <span class="text-danger">
                <span>* {{ $message }}</span>
            </span>
            @enderror

        </div>

        <div class="input-content">
            <input type="password" name="password" placeholder="Contraseña" value="">

            @error('password')
            <span class="text-danger">
                <span>* {{ $message }}</span>
            </span>
            @enderror

        </div>
    </div>

    <a href="{{ route('password.request') }}" class="password-reset">Olvidé mi contraseña</a>

    <input type="submit" value="Iniciar sesión" class="button">
</form>

<p>¿No tienes una cuenta? <a href="{{ route('register') }}" class="link">Crear cuenta</a></p>
@endsection