@extends('layouts.app')

@section('content')
<center>
    <img src="{{ url($facebook_account->image->path) }}" height="100">
    <h1>Perfil Facebook de {{ $facebook_account->full_name }}</h1>

    <table border="1">
        <tr>
            <th colspan="5">
                Posts
            </th>
        </tr>
        <tr>
            <th>Titulo</th>
            <th>Descripcion</th>
            <th>Imagenes</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        @foreach ($facebook_account->posts as $post)
        <tr>
            <th>{{ $post->title }}</th>
            <th>{{ $post->description }}</th>
            <th>
                @foreach ($post->images as $image)
                <img src="{{ url($image->path) }}" height="100">
                @endforeach
            </th>
            <th>{{ $post->status->name }}</th>
            <th>
                <a href="{{ url('profile/'.$facebook_account->id.'/post/'.$post->id.'/details') }}">
                    Ver detalles
                </a>
                <br />
                <a href="{{ url('profile/'.$facebook_account->id.'/post/'.$post->id.'/record') }}">
                    Ver historial
                </a>
                <br /><br />
                <form method="post" action="{{ url('profile/'.$facebook_account->id.'/post/'.$post->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>
            </th>
        </tr>
        @endforeach
    </table>
</center>
@endsection