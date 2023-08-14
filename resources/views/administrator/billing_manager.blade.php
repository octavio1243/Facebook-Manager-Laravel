@extends('layouts.app')

@section('content')
<center>
    <h2>Datos cliente</h2>
    <p> Correo: {{ $user->email }}</p>
    <p>Nombre completo: {{ $user->name.' '.$user->surname }}</p>
    
    <a href="{{ route('user.plan',['user_id'=>$user->id]) }}">Crear plan</a>
    @php
    $plans=$user->plans;
    @endphp
    @include('components.billing_table')
</center>
@endsection