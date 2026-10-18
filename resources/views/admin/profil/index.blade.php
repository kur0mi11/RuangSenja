@extends('admin.layouts.app')

@section('title', 'Profil Saya')
@section('heading', 'Profil Saya')

@section('content')

@include('components.profil-form', [
    'pengguna'      => $pengguna,
    'updateRoute'   => 'admin.profil.update',
    'passwordRoute' => 'admin.profil.password',
])

@endsection
