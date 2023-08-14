@extends('layouts.app')

@section('content')
    <center>
        <img src="{{ url($facebook_account->image->path) }}" height="100">
        <h1>Perfil Facebook de {{ $facebook_account->full_name }}</h1>

        <h3>Titulo: {{ $post->title }}</h3>

        <!--
        <h3>Descripcion: {{ $post->description }}</h3>
        <h3>Imagenes: </h3>
        @foreach ($post->images as $image)
            <img src="{{ url($image->path) }}" height="100">
        @endforeach
        <h3>Estado: {{ $post->status->name }}</h3>
        -->

        <table border="1">
            <tr>
                <th colspan="6">
                    Historial
                </th>
            </tr>
            <tr>
                <th>ID Grupo</th>
                <th>Nombre Grupo</th>
                <th>Imagen Grupo</th>
                <th>Fecha Creacion</th>
                <th>Estado</th>
                <th>URL del post</th>
            </tr>
            @foreach ($records as $record)
                <tr>
                    <th>{{ $record->group_post->group->group_id }}</th>
                    <th>{{ $record->group_post->group->name }}</th>
                    <th>
                        <img src="{{ $record->group_post->group->url }}" height="100">
                    </th>
                    <th>{{ $record->created_at}}</th>
                    <th>{{ $record->status->name}}</th>
                    <th>{{ $record->post_url}}</th>
                </tr>
            @endforeach
        </table>

        

    </center>

    

    

@endsection
