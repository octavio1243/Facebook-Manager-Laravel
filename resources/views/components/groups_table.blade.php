<table border="1">
    <tr>
        <th colspan="{{count($table_head)}}">
            Grupos
        </th>
    </tr>
    <tr>
        @foreach ($table_head as $column)
        <th>{{$column}}</th>
        @endforeach
    </tr>
    @foreach ($all_groups as $group)
        <tr>
            @foreach ($table_head as $column)
                @if( "ID"== $column )
                <th>{{ $group->group_id }}</th>
                @elseif( "Nombre"== $column )
                <th>{{ $group->name }}</th>
                @elseif( "Imagen"== $column )
                <th>
                    <img src="{{ $group->url }}" height="100">
                </th>
                @elseif("Seleccionados"== $column )
                <th>
                    @php
                    if (isset($post)){
                        $group_post = $post->group_posts->where('group_id',$group->id)->first();
                    }
                    @endphp
                    @if( isset($group_post) && strcmp($group_post->status->name,'Habilitado') == 0 )
                    <input type="checkbox" name="groups[]" value="{{ $group->group_id }}" checked />
                    @else
                    <input type="checkbox" name="groups[]" value="{{ $group->group_id }}" />
                    @endif
                </th>
                @endif
            @endforeach
        </tr>
    @endforeach
</table>