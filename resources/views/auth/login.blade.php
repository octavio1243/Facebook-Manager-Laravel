@extends('layouts.app')

@section('content')
    <center>
        <form action="/login" method="POST">
            @csrf

            <br><label >Email:</label>
            <input type="email" name="email">

            <br><label >Contraseña:</label>
            <input type="password" name="password">
        
            <br><input type="submit" value="Logear">
        </form>
    </center>
@endsection