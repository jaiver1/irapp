@include('layouts.guest.nav_bar')
@section('css_auth')
<link rel="stylesheet" href="{{ asset('css/store/style.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/store/store.min.css') }}" type="text/css">
@endsection
@section('js_auth')
<script type="text/javascript">
function salir(){
    event.preventDefault();
    swal({
  title: 'Salir',
  text: '¿Desea cerrar la sesion"?',
  type: 'question',
  confirmButtonText: '<i class="fa fa-check"></i> Si',
  cancelButtonText: '<i class="fa fa-times"></i> No',
  showCancelButton: true,
  showCloseButton: true,
  confirmButtonClass: 'btn btn-success',
  cancelButtonClass: 'btn btn-danger',
  buttonsStyling: false,
  animation: false,
  customClass: 'animated zoomIn',
}).then((result) => {
  if (result.value) {
    $("#logout-form").submit();
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
</script>
@endsection
@section('navegation')
<header>
    @yield('nav_bar')
</header>
@endsection
