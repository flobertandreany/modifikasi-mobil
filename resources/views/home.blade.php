@extends('layouts.main')

@section('content')
    <h1>Halaman User</h1>
    <h2> {{ $nama }}</h2>
    <img src="img/login/{{ $image }}" alt="{{ $image }}" width="200">
@endsection
@push('content_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>

    </style>
@endpush
@push('content_js')
    <script src="{{ asset('js/script.js') }}"></script>
    <script>

    </script>
@endpush
