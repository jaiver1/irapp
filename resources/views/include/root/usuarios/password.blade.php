@section('password_form')

    <!--Grid row-->
    <div class="row mt-5">


            <!--Grid column-->
            <div class="col-12">

                <!--Card-->
                <div class="card hoverable"> 
                    <!--Card content-->
                    <div class="card-body card-alta">
                            <div class="d-sm-flex justify-content-between">
                                    <h4><i class="fas fa-unlock-alt mr-2"></i>
                                    Cambiar contraseña
                                </h4>                               
                                </div>
                                <hr/>
                                <div class="row center">
                                        <div class="col-12">
<form id="uploadForm" action="{{ route('profile.uploadImagen',$usuario->id) }}" method="POST" accept-charset="UTF-8">
  <!-- Grid row -->
<div class="form-row">
        <!-- Grid column -->
        <div class="col-md-6">
            <!-- Material input -->
            <div class="md-form">
    <i class="fas fa-unlock-alt prefix"></i>
    <input type="password" required id="password" value="{{ old('password') }}" name="password" class="form-control validate" maxlength="50">
    <label for="pass" data-error="Error" data-success="Correcto">Contraseña *</label>
</div>
@if ($errors->has('password'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                           {{ $errors->first('password') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
                                
                                @endif
        </div>
        <!-- Grid column -->
        <div class="col-md-6">
            <!-- Material input -->
            <div class="md-form">
    <i class="fas fa-lock prefix"></i>
    <input type="password" required id="password_confirmation" value="{{ old('password_confirmation') }}" name="password_confirmation" class="form-control validate" maxlength="50">
    <label for="password_confirmation" data-error="Error" data-success="Correcto">Confirmar Contraseña *</label>
</div>
@if ($errors->has('password_confirmation'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                           {{ $errors->first('password_confirmation') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
                                
                                @endif
        </div>
        <!-- Grid column -->
        </div>
    <!-- Grid row -->
</form>
</div>
</div>
</div>
</div>
<!--/.Card-->
</div>
<!--Grid column-->
</div>
<!--Grid row-->
@endsection

@section('password_script')
<script type="text/javascript">

</script>
    @endsection