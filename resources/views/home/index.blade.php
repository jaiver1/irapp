@extends('layouts.dashboard.main')
@if(Auth::user()->authorizeRoles(['ROLE_COLABORADOR','ROLE_CLIENTE'],FALSE))
@include('home.main_usuario')
@endif

@if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],FALSE))
@include('home.main_administrador')
@endif