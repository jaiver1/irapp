<select class="form-control" required id="ciudad_id" name="ciudad_id">
    <option value="" disabled selected>Selecciona una opción</option>
    @foreach($paises as $key => $pais)
    <optgroup label="{{ $pais->nombre }}">
    @foreach($pais->departamentos as $key => $departamento)
    <optgroup label="&nbsp;&nbsp;{{ $departamento->nombre }}">
    @foreach($departamento->ciudades as $key => $ciudad)
    <option {{ old('ciudad_id') ?  ((old('ciudad_id') == $ciudad->id) ? 'selected' : '') : (($ciudad_selected->id == $ciudad->id) ? 'selected' : '') }} value="{{ $ciudad->id }}">&nbsp;&nbsp;&nbsp;&nbsp;{{$ciudad->nombre}}</option>
    @endforeach
    @endforeach
    @endforeach
    </select>