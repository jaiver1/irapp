<select class="form-control" required id="categoria_id" name="categoria_id">
                <option value="-1" selected>Categoria principal</option>
                @foreach($categorias as $sub)
                @if($sub->categoria == NULL)
                @include('include.clasificacion.categorias_parent.options', array('sub'=> $sub,'niv'=> 0))
                @endif
                @endforeach
            </select>