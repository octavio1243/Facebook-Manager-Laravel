@extends('layouts.app')

@section('head')
<style>
    .img-wrap {
        position: relative;
        display: inline-block;
        border: 1px red solid;
        font-size: 0;
    }

    .img-wrap .close {
        position: absolute;
        top: 2px;
        right: 2px;
        z-index: 100;
        background-color: #FFF;
        padding: 5px 2px 2px;
        color: #000;
        font-weight: bold;
        cursor: pointer;
        opacity: .2;
        text-align: center;
        font-size: 22px;
        line-height: 10px;
        border-radius: 50%;
    }

    .img-wrap:hover .close {
        opacity: 1;
    }
</style>
<script>
    // Cargar foto como imagen de previsualizacion
    var loadFile = function(event) {
        var images_preview = document.getElementById('images_preview');
        Array.from(event.target.files).forEach((file) => {
            url = URL.createObjectURL(file);
            text = `
            <div class="img-wrap">
                <span onclick="deleteFile(event)" class="close">&times;</span>
                <img src="${url}" style="height: 100px;">
                <input type="file" name="images[]" style="display:none;" >
            </div>`;
            images_preview.insertAdjacentHTML('beforeend', text);
            var arrInput = document.getElementsByName('images[]');
            i = arrInput.length - 1;
            var dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            arrInput[i].files = dataTransfer.files;
        });
        var arrInput= document.getElementsByName('images[]');
        arrInput[0].value = null;  
    };

    // Eliminar imagen de previsualizacion
    var deleteFile = function(event) {
        event.target.parentElement.remove();
    };
</script>
@endsection

@section('content')
<center>
    <img src="{{ url($facebook_account->image->path) }}" height="100">
    <h1>Perfil Facebook de {{ $facebook_account->full_name }}</h1>

    <h2>Datos del post</h2>
    <form method="post" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="fname">Titulo:</label>
            <input type="text" id="title" name="title">
        </div>
        </br>
        <div>
            <label for="fname">Descripcion:</label>
            <input type="text" id="description" name="description">
        </div>
        </br>
        <div>
            <label for="fname">Imagenes:</label>
            <input type="file" name="images[]" multiple="multiple" accept="image/jpeg, image/png, image/jpg" onchange="loadFile(event)">
            <br /><br />
            <div id="images_preview">

            </div>
        </div>
        </br>
        @php
        $table_head = array("Seleccionados","ID","Nombre","Imagen");
        @endphp
        @include('components.groups_table')
        </br>
        <div>
            <button>Crear Post</button>
        </div>
    </form>

</center>
@endsection