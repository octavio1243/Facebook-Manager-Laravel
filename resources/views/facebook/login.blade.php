@extends('layouts.app')

@section('content')
    <center>
        <h1>Login de facebook</h1>
        <form action="/facebook_login" method="POST">
            @csrf

            <br><label>Email:</label>
            <input type="email" name="email">

            <br><label>Contraseña:</label>
            <input type="password" name="password">

            <br><label>Confirmacion contraseña:</label>
            <input type="password" name="password_confirmation">

            <br><input type="submit" value="Iniciar sesion">
        </form>
    </center>
@endsection
