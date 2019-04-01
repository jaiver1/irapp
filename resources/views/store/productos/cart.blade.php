@extends('layouts.store.main')
@include('include.addons.gmaps.form', array('ubicacion'=>Auth::user()->getCliente()->persona->direccion->ubicacion,'infowindow'=>Auth::user()->getCliente()->persona->primer_nombre." ".Auth::user()->getCliente()->persona->segundo_nombre." ".Auth::user()->getCliente()->persona->primer_apellido." ".Auth::user()->getCliente()->persona->segundo_apellido))
@include('include.dato_basico.direcciones.form', array('direccion'=>Auth::user()->getCliente()->persona->direccion))

@section('template_title')
Carrito de productos | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/select2.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('css/addons/bootstrap-material-datetimepicker.css')}}" type="text/css"/>
<style type="text/css">
    body {
        background: url("{{ asset('img/guest/store/producto/background.jpg') }}")no-repeat center center;
        background-size: cover;
    }
    </style>
@endsection
@section('content')
<section class="view intro-2">
        <div class="mask pattern-6 flex-center"></div>
<!-- Main Container -->
<div class="container mt-5 pt-3">
    <!--Navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark unique-color-dark mt-4 mb-4 z-depth-5 hoverable" >

        <!-- Navbar brand -->
        <a class="mr-4 d-md-block" href="{{ route('store.productos') }}"><h5 class="h5-responsive font-weight-bold white-text">Lista de productos</h5></a>
     
    
 {{--
        <!-- Collapse button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1"
            aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>



        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent1">

            <!-- Links -->
           
            <ul class="navbar-nav mr-auto">
                
                <li class="nav-item dropdown mega-dropdown active">
                    <a class="nav-link dropdown-toggle no-caret" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Clasificación</a>
                    <div class="dropdown-menu mega-menu v-2 row z-depth-1 white" aria-labelledby="navbarDropdownMenuLink1">
                        <div class="row mx-md-4 mx-1">
                            <div class="col-md-12 col-lg-4 sub-menu my-lg-5 mt-5 mb-4">
                                <h6 class="sub-title text-uppercase font-weight-bold red-text">Destacado</h6>
                                <!--Featured image-->
                                <div class="view overlay mb-3 z-depth-1 hoverable waves-effect zoom">
                                    <img src="https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/Products/9.jpg" class="img-fluid hoverable rounded img-thumbnail" alt="First sample image">

                                    <div class="mask flex-center rgba-white-slight">
                                        <p></p>
                                    </div>
                                </div>
                                <h4 class="mb-2"><a class="news-title-2 pl-0" href="">Lorem ipsum dolor sit</a></h4>
                            </div>
                            <div class="col-md-6 col-lg-4 sub-menu my-lg-5 my-4">
                                <h6 class="sub-title text-uppercase font-weight-bold red-text">Marcas</h6>
                                <ul class="caret-style pl-0">
                                    <li class=""><a class="menu-item" href="">Canon</a></li>
                                    <li class=""><a class="menu-item" href="">Nikon</a></li>
                                    <li class=""><a class="menu-item" href="">Sony</a></li>
                                    <li class=""><a class="menu-item" href="">GoPro</a></li>
                                    <li class=""><a class="menu-item" href="">Samsung</a></li>
                                </ul>
                            </div>
                            <div class="col-md-6 col-lg-4 sub-menu my-lg-5 my-4">
                                <h6 class="sub-title text-uppercase font-weight-bold red-text">Categorias</h6>
                                <ul class="caret-style pl-0">
                                    <li class=""><a class="menu-item" href="">Excepteur sint</a></li>
                                    <li class=""><a class="menu-item" href="">Sunt in culpa</a></li>
                                    <li class=""><a class="menu-item" href="">Sed ut perspiciatis</a></li>
                                    <li class=""><a class="menu-item" href="">Mollit anim id est</a></li>
                                    <li class=""><a class="menu-item" href="">Accusantium doloremque</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            
            <!-- Links -->

            <!-- Search form -->
            
        </div>
        <!-- Collapsible content -->
--}}
    </nav>
    <!--/.Navbar-->
   
        <!-- Content -->
        <div class="col-12" >

          

           <!-- Products Grid -->
           <section class="section pt-4" >

                <!-- Grid row -->
                <div class="row">
                        <div class="col-12">
                        <div class="card mb-4 z-depth-5 hoverable">
                                <div class="card-body">
                                        @if(Auth::user()->getCliente()->productos->count() > 0)
                                        <form id="invoice_form" method="POST" action="{{ route('store.register.venta') }}" accept-charset="UTF-8">
                                            
                                            {{ csrf_field() }}


                                        @yield('direccion_form')

                                        @yield('gmaps_form')

                                        <div class="d-sm-flex justify-content-between mt-4">
                                        

                                        <h4><i class="fas fa-shopping-cart mr-2"></i>
                                            @if (Auth::user()->getCliente()->productos->count() === 1)
                                        Un producto
                                        @elseif (Auth::user()->getCliente()->productos->count() > 1)
                                        {{ Auth::user()->getCliente()->productos->count() }} productos
                                        @else
                                        No hay productos
                                        @endif
                                        </h4>
        </div> 

                                        <hr/>

                                        
                   
            @php
            $venta = 0
            @endphp  
        @foreach(Auth::user()->getCliente()->productos as $key => $producto)
        @php
            $venta += $producto->valor_unitario 
            @endphp  
        <h5 class="h5-responsive">{{$producto->nombre}}</h5>
        <input name="producto[]" type="hidden" readonly required type="text" value="{{$producto->id}}">
        <div class="form-row">
            <div class="col-md-3">
                    <div class="md-form">
            <i class="prefix fas fa-sort-numeric-down"></i>
            <input onchange="calcular({{$producto->id}})" type="number"  required id="cantidad{{$producto->id}}" value="1" name="cantidad[]" class="form-control validate"  min="1">
                    <label for="cantidad{{$producto->id}}" data-error="Error" data-success="Correcto">Cantidad*</label>
            </div>
            </div> 
        
        <div class="col-md-4">
                <div class="md-form">
        <i class="prefix fas fa-money-bill-alt"></i>
        <input type="number"  required id="valor{{$producto->id}}" value="{{ $producto->valor_unitario }}" name="valor[]" class="form-control validate"  readonly min="0">
                <label for="valor{{$producto->id}}" data-error="Solo lectura" data-success="Correcto">Valor unitario*</label>
        </div>
        </div> 
    
<div class="col-md-4">
        <div class="md-form">
<i class="prefix fas fa-money-check-alt"></i>
<input type="number"  required id="total{{$producto->id}}" value="{{ $producto->valor_unitario }}" name="total[]" class="form-control validate"  readonly min="0">
        <label for="total{{$producto->id}}" data-error="Solo lectura" data-success="Correcto">Total*</label>
</div>
</div> 
<div class="col-md-1 text-center">
<a onclick="eliminar_producto({{ $producto->id }},'{{ $producto->nombre }}')" class="btn btn-outline-danger btn-circle waves-effect hoverable"
    data-toggle="tooltip" data-placement="bottom" title="Eliminar producto">
  <i class="fas fa-2x fa-trash-alt"></i>
</a>

    </div>
</div>

  @endforeach
  <div class="form-row">

  <div class="col-md-4 offset-md-7">
        <div class="md-form">
<i class="prefix fas fa-file-invoice-dollar"></i>
<input type="number"  required id="venta" value="{{ $venta }}" name="venta" class="form-control validate"  readonly min="0">
        <label for="venta" data-error="Solo lectura" data-success="Correcto">Total*</label>
</div>
</div> 
<div class="col-md-1 text-center">
        <a onclick="validar()" class="btn btn-xl btn-outline-success btn-circle waves-effect hoverable"
            data-toggle="tooltip" data-placement="bottom" title="Registrar venta">
          <i class="fas fa-2x fa-check"></i>
        </a>
            </div>
</div>
    
 
</form>
@foreach(Auth::user()->getCliente()->productos as $key => $producto)
<form id="eliminar{{ $producto->id }}" method="POST" action="{{ route('store.productos.cart.delete', $producto->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="DELETE">
    {{ csrf_field() }}
</form> 
@endforeach
@else

<form method="post" action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/">
    <input name="merchantId"    type="hidden"  value="508029"   >
    <input name="accountId"     type="hidden"  value="512321" >
    <input name="description"   type="hidden"  value="Test PAYU"  >
    <input name="referenceCode" type="hidden"  value="TestPayU" >
    <input name="amount"        type="hidden"  value="20000"   >
    <input name="tax"           type="hidden"  value="3193"  >
    <input name="taxReturnBase" type="hidden"  value="16806" >
    <input name="currency"      type="hidden"  value="COP" >
    <input name="signature"     type="hidden"  value="7ee7cf808ce6a39b17481c54f2c57acc"  >
    <input name="test"          type="hidden"  value="1" >
    <input name="buyerFullName"    type="hidden"  value="{{Auth::user()->email}}" >
    <input name="buyerEmail"    type="hidden"  value="{{Auth::user()->getCliente()->persona->primer_nombre}} {{Auth::user()->getCliente()->persona->segundo_nombre}} {{Auth::user()->getCliente()->persona->primer_apellido}} {{Auth::user()->getCliente()->persona->segundo_apellido}}" >
    <input name="responseUrl"    type="hidden"  value="http://www.test.com/response" >
    <input name="confirmationUrl"    type="hidden"  value="http://www.test.com/confirmation" >
    <input name="Submit"        type="submit"  value="Enviar" >
  </form>
<div class="col-12">
        <div class="d-flex justify-content-center">
        <h1 class="h1-responsive error-display hoverable">
                No se encontraron productos
        </h1>
    </div> </div>
@endif
                                    </div>
                                </div>
            </div>
        </div>
            <!--Grid row-->
       
            </section>
            <!-- /.Products Grid -->
        </div>
        <!-- /.Content -->

    </div>
</div>
</div>
</div>
<!-- /.Main Container -->
</section>
@endsection

@section('js_links')
<script type="text/javascript" src="{{ asset('js/addons/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/i18n/es.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/addons/bootstrap-material-datetimepicker.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/addons/validation/jquery.validate.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/validation/messages_es.js') }}"></script>
<script type="text/javascript">

function validar(){
  if($("#invoice_form").validate({
    lang: 'es',
    errorPlacement: function(error, element){
      $(element).parent().after(error);
		}})){
            var nombre = $("#nombre").val();
            swal({
  title: 'Registrar venta',
  text: '¿Desea registrar la venta "'+nombre+'"?',
  type: 'success',
  confirmButtonText: '<i class="fas fa-check"></i> Si',
  cancelButtonText: '<i class="fas fa-times"></i> No',
  showCancelButton: true,
  showCloseButton: true,
  confirmButtonClass: 'btn btn-success',
  cancelButtonClass: 'btn btn-danger',
  buttonsStyling: false,
  animation: false,
  customClass: 'animated zoomIn',
}).then((result) => {
  if (result.value) {
    $("#invoice_form").submit();
  }else{
    swal({
  position: 'top-end',
  type: 'error',
  title: 'Operación cancelada por el usuario',
  showConfirmButton: false,
  toast: true,
  animation: false,
  customClass: 'animated lightSpeedIn',
  timer: 3000
})
  }
})

   
  }
  }

  function eliminar_producto(id,nombre){
    swal({
  title: 'Eliminar el producto',
  text: '¿Desea eliminar el producto "'+nombre+'"?',
  type: 'question',
  confirmButtonText: '<i class="fas fa-check"></i> Si',
  cancelButtonText: '<i class="fas fa-times"></i> No',
  showCancelButton: true,
  showCloseButton: true,
  confirmButtonClass: 'btn btn-success',
  cancelButtonClass: 'btn btn-danger',
  buttonsStyling: false,
  animation: false,
  customClass: 'animated zoomIn',
}).then((result) => {
  if (result.value) {
    $( "#eliminar"+id ).submit();
  }else{
    swal({
  position: 'top-end',
  type: 'error',
  title: 'Operación cancelada por el usuario',
  showConfirmButton: false,
  toast: true,
  animation: false,
  customClass: 'animated lightSpeedIn',
  timer: 3000
})
  }
})
}

  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
function calcular(id){
    var valor = parseInt($("#valor"+id).val());
    var cantidad = parseInt($("#cantidad"+id).val());
    var total = valor*cantidad;

    var resta = parseInt($("#total"+id).val());
    var venta = parseInt($("#venta").val());

    var full = (venta - resta) + total;

    $("#total"+id).val(total);
    $("#venta").val(full)
}

$('#ciudad_id').select2({
        placeholder: "Ciudades",
        theme: "material",
        language: "es"
    });

    $(".select2-selection__arrow")
        .addClass("fas fa-chevron-down");

        $('#fecha_inicio').bootstrapMaterialDatePicker({

// enable date picker
date : true, 

// enable time picker
time : true, 

// custom date format
format : 'YYYY-MM-DD HH:mm', 

// min / max date
minDate : null, 
maxDate : null, 

// current date
currentDate : null, 

// Localization
lang : 'es', 

// week starts at
weekStart : 1, 

// short time format
shortTime : false, 

// text for cancel button
'cancelText' : '<i class="fas fa-times fa-2x"></i>', 

// text for ok button
'okText' : '<i class="fas fa-check fa-2x"></i>' 

});
</script>

@yield('gmaps_links')
@endsection
