@extends('layouts.app')

@section('content')
@auth
    <p>Welcome, {{ auth()->user()->name }}!</p>
    <p>Email: {{ auth()->user()->email }}</p>
    <p>Other user details...</p>
@endauth

@endsection