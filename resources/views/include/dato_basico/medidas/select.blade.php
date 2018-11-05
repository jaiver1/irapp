<select class="form-control" required id="medida_id" name="medida_id">
        <option value="" disabled selected>Selecciona una opción</option>
        @foreach($tipos_medidas as $key => $tipo_medida)
        <optgroup label="{{ $tipo_medida->nombre }}">
        @foreach($tipo_medida->medidas as $medida)
        <option {{ old('medida_id') ?  ((old('medida_id') == $medida->id) ? 'selected' : '') : (($medida_selected->id == $medida->id ) ? 'selected' : '') }} value="{{$medida->id}}">{{$medida->nombre}}</option>
        @endforeach
        @endforeach
    </select>