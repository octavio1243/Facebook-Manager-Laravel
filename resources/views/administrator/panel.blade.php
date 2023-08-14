@extends('layouts.app')

@section('content')
<center>
    <h2>Clientes</h2>
    <table border="1">
        <tr>
            <th>Correo</th>
            <th>Nombre Completo</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        @foreach ($users as $user)
        <tr>
            <th>{{ $user->email }}</th>
            <th>{{ $user->name.' '.$user->surname }}</th>
            <th>{{ $user->status->name }}</th>
            <th>
                <a href="{{ route('user.billing_manager',['user_id'=>$user->id]) }}">Administrar plan</a>
            </th>
        </tr>
        @endforeach
    </table>
</center>
@endsection