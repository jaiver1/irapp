@extends('layouts.dashboard.main')
@section('template_title')
Página principal | {{ config('app.name', 'Laravel') }}
@endsection
@section('footer_title')
Página principal | {{ config('app.name', 'Laravel') }}
@endsection
@role(['ROLE_COLABORADOR'])
@include('home.main_colaborador')
@endrole

@role(['ROLE_ROOT','ROLE_ADMINISTRADOR'])
@include('home.main_administrador')
@endrole