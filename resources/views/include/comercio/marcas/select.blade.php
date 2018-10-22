<select class="form-control" required id="marca_id" name="marca_id">
        <option value="" disabled selected>Selecciona una opción</option>
        @foreach($marcas as $key => $marca)
        <option {{ ($marca_selected->id == $marca->id) ? 'selected' : '' }} value="{{$marca->id}}">{{$marca->nombre}}</option>
        @endforeach
    </select>