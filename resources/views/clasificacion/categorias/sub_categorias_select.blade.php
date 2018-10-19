<select class="form-control" required id="categoria_id" name="categoria_id">
                <option value="" disabled selected>Selecciona una opción</option>
                @foreach($especialidades as $key => $especialidad)
                <optgroup label="{{ $especialidad->nombre }}">
                @foreach($especialidad->categorias as $sub)
                @if($sub->categoria == NULL)
                @include('clasificacion.categorias.sub_categorias_options', array('sub'=> $sub,'niv'=> 0))
                @endif
                @endforeach
                @endforeach
            </select>