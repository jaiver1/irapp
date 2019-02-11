@extends('layouts.dashboard.main')
@section('template_title')
Página principal | {{ config('app.name', 'Laravel') }}
@endsection
@section('footer_title')
Página principal | {{ config('app.name', 'Laravel') }}
@endsection
@if(Auth::user()->authorizeRoles('ROLE_COLABORADOR',FALSE))
@include('home.main_colaborador')
@endif

@if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],FALSE))
@include('home.main_administrador')
@endif