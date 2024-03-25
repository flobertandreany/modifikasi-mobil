@extends('layouts.main')

@section('content')
    <h1>Halaman User</h1>
    <h2> {{ $nama }}</h2>
    <img src="img/login/{{ $image }}" alt="{{ $image }}" width="200">
@endsection
