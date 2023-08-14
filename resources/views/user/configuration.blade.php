@extends('layouts.app')

@section('content')
<center>
    <h2>Datos</h2>
    <p>Nombre Completo: {{ $user->name.' '.$user->surname }}</p>
    <p>Correo: {{ $user->email }}</p>
    <p>Rol: {{ $user->rol->name }}</p>
    <p>Estado: {{ $user->status->name }}</p>
</center>
@endsection