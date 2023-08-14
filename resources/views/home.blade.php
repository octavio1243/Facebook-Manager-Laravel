@extends('layouts.app')

@section('content')
<center>
    <a href="{{ route('facebook_login') }}">Asociar cuenta de facebook</a></br></br>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Imagen de perfil</th>
            <th>Nombre Completo</th>
            <th>Correo</th>
            <th>Rate</th>
            <th>Estado</th>
        </tr>
        @foreach ($facebook_accounts as $facebook_account)
        <tr>
            <th>{{ $facebook_account->uid }}</th>
            <th>
                <img src="{{ url($facebook_account->image->path) }}" height="100">
            </th>
            <th>
                <a href="{{ route('profile.account',['facebook_account_id'=>$facebook_account->id]) }}">
                    {{ $facebook_account->full_name }}
                </a>
            </th>
            <th>{{ $facebook_account->email }}</th>
            <th>{{ $facebook_account->rate }}</th>
            <th>{{ $facebook_account->status->name }}</th>

        </tr>
        @endforeach
    </table>
</center>
@endsection