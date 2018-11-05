@include('include.contacto.personas.form', array('persona'=>$cliente->persona))
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/select2.css') }}" type="text/css"/>
@endsection
@section('crud_form')

@if($editar)
<form method="POST" action="{{ route('clientes.update', $cliente->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="PUT">
    @else
    <form method="POST" action="{{ route('clientes.store') }}" accept-charset="UTF-8">
@endif

 {{ csrf_field() }}
    <!-- Grid row -->
    <div class="form-row">
        <!-- Grid column -->
        <div class="col-md-12">

            <!-- Material input -->
            @yield('persona_form')
        </div>
        <!-- Grid column -->
        </div>
    <!-- Grid row -->


    <button type="submit" class="mt-4 waves-effect btn {{($editar) ? 'btn-warning' : 'btn-success'}} btn-md hoverable">
    <i class="fa fa-2x {{($editar) ? 'fa-pencil-alt' : 'fa-plus'}}"></i> {{($editar) ? 'Editar' : 'Registrar'}}
    </button>
</form>
@endsection

@section('js_links')
<script type="text/javascript" src="{{ asset('js/addons/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/i18n/es.js')}}"></script>
<script type="text/javascript">
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

  $('#usuario_id').select2({
            placeholder: "Usuarios",
            theme: "material",
            language: "es"
        });
    
        $('#ciudad_id').select2({
            placeholder: "Ciudades",
            theme: "material",
            language: "es"
        });
        $(".select2-selection__arrow")
            .addClass("fa fa-chevron-down");
</script>

@yield('gmaps_links')
@endsection