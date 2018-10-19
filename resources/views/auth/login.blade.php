@extends('layouts.guest.main')
@section('template_title')
Iniciar sesión | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/guest/auth/style.css') }}" type="text/css">
<style type="text/css">
.intro-2 {
    background: url("{{ asset('img/guest/login/background.jpg') }}")no-repeat center center;
    background-size: cover;
}
</style>
@endsection
@section('content')
  <!--Intro Section-->
  <section class="view intro-2 hm-gradient">
                <div class="full-bg-img">
                    <div class="container flex-center">
                        <div class="d-flex align-items-center content-height">
                            <div class="row flex-center pt-5 mt-3">
                     
                                <div class="col-md-6 mb-5">
                                    <!--Form-->
                                    <div class="card wow fadeInRight" data-wow-delay="0.3s">
                                        <div class="card-body">
                                            <!--Header-->
                                            <div class="text-center">
                                                <h3 class="white-text"><i class="fa fa-door-closed mr-2"></i>Iniciar sesión</h3>
                                                <hr class="hr-light">
                                            </div>
                                            <form method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                                            <div class="md-form">
                                                <i class="fa fa-envelope prefix white-text"></i>
                                                <input id="email" type="email" class="form-control validate white-text" name="email" value="{{ old('email') }}" required autofocus>
                                                <label for="email" data-error="Error" data-success="Correcto">Email</label>
                                            </div>
                                            @if ($errors->has('email'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                           {{ $errors->first('email') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
                                
                                @endif

                                            <div class="md-form">
                                                <i class="fa fa-lock prefix white-text"></i>
                                                <input id="password" type="password" class="form-control validate white-text" name="password" required>
                                                <label for="password" data-error="Error" data-success="Correcto">Contraseña</label>
                                            </div>
                                            @if ($errors->has('password'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ $errors->first('password') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

                                            <div class="text-center">
                                                <button class="btn btn-indigo"><i class="fa fa-door-closed mr-2"></i>Iniciar sesión</button>
                                                   
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!--/.Form-->
                                    
                                </div>
                                           <div class="text-center text-md-left  col-md-6 col-xl-5 offset-xl-1">
                                    <div class="white-text">
                                        <h1 class="h1-responsive font-weight-bold wow fadeInLeft" data-wow-delay="0.3s">Sign up right now! </h1>
                                        <hr class="hr-light wow fadeInLeft" data-wow-delay="0.3s">
                                        <h6 class="wow fadeInLeft" data-wow-delay="0.3s">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem repellendus quasi fuga nesciunt dolorum nulla magnam veniam sapiente, fugiat! Commodi sequi non animi ea dolor molestiae, quisquam iste, maiores. Nulla.</h6>
                                        <br>
                                        <a class="btn btn-outline-white wow fadeInLeft" data-wow-delay="0.3s">Learn more</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
@endsection