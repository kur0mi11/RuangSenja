@extends('donatur.layouts.app')

@section('title', 'Profil Saya')
@section('heading', 'Profil Saya')

@section('content')

@include('components.profil-form', [
    'pengguna'      => $pengguna,
    'updateRoute'   => 'donatur.profil.update',
    'passwordRoute' => 'donatur.profil.password',
    'ringkasan'     => $ringkasan,
])

@endsection
