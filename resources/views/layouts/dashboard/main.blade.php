@extends('layouts.app')
@section('main')
@include('layouts.dashboard.nav')
<div class="page-wrapper ice-theme sidebar-bg bg1 toggled">
        <a id="show-sidebar" class="btn btn-dark" href="#">
            <i class="fas fa-2x fa-bars"></i>
        </a>
@yield('navegation')
<main class="page-content">
@yield('content')
</main>
    </div>
@endsection
