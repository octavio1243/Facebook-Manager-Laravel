@extends('layouts.app')

@section('content') 
    <center>
        <img src="{{ url($facebook_account->image->path) }}" height="100">
        <h1>Perfil Facebook de {{ $facebook_account->full_name }}</h1>
        @php
        $table_head = array("ID","Nombre","Imagen");
        @endphp
        @include('components.groups_table')
    </center>
@endsection 
