<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    @yield('head')

</head>

<body>
    <center>
        <p>
            @guest
            <a href="/login">Iniciar sesion</a> |
            <a href="/register">Registrar</a>
            @endguest
            @auth
                @if ( strcmp(session()->get("rol"),'Administrador')==0 )
                    <a href="/panel">Home</a> |
                @else
                    <a href="/home">Home</a> |
                    @if(Route::is('profile.*') )
                        <a href="/profile/{{ $facebook_account->id }}">Perfil</a> |
                        <a href="/profile/{{ $facebook_account->id }}/post"> Crear post</a> |
                        <a href="/profile/{{ $facebook_account->id }}/groups">Mis Grupos</a> |
                    @endif
                    <a href='/billing'>Facturación</a> |
                @endif
                <a href='/configuration'>Configuracion</a> |
                <a href='/logout'>Cerrar sesion</a>
            @endauth     
        </p>
        </br>
    </center>  

    @yield('content')

    @yield('scripts')
</body>

</html>