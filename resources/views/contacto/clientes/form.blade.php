@include('include.contacto.personas.form', array('persona'=>$cliente->persona))
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
<script type="text/javascript">
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

@yield('gmaps_links')
@endsection