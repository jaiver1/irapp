@if($categoria_selected->id != $sub->id)
<option value="{{ $sub->id }}" {{($categoria_selected->categoria && $categoria_selected->categoria->id == $sub->id ) ? 'selected' : '' }}>
@for($i=0; $i < 2*$niv; $i++)
&nbsp;
@endfor

{{ $sub->nombre }}
</option>
@if($sub->categorias->count())
        @foreach($sub->categorias as $sub2)
        @include('clasificacion.categorias.sub_categorias_options', array('sub'=> $sub2,'niv'=> $niv+1))
        @endforeach
        @endif

@endif