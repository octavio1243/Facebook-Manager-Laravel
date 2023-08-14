@extends('layouts.app')

@section('content')
    <center>
        <form action="/register" method="POST">
            @csrf
            <br><label >Nombre:</label>
            <input type="text" name="name">
            
            <br><label >Apellido:</label>
            <input type="text" name="surname">
            
            <br><label >Email:</label>
            <input type="email" name="email">

            <br><label >Contraseña:</label>
            <input type="password" name="password">

            <br><label >Confirmacion contraseña:</label>
            <input type="password" name="password_confirmation">
        
            <br><input type="submit" value="Registrarse">
        </form>
    </center>
@endsection