<select class="form-control" required id="categoria_id" name="categoria_id">
                <option value="" disabled selected>Selecciona una opción</option>
                @foreach($categorias as $sub)
                @if($sub->categoria == NULL)
                @include('include.clasificacion.categorias.options', array('sub'=> $sub,'niv'=> 0))
                @endif
                @endforeach
            </select>