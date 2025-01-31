@extends('layouts.global-layout')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Login</h2>
        @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-600 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Email" class="w-full p-3 border rounded mb-3">
            <input type="password" name="password" placeholder="Password" class="w-full p-3 border rounded mb-3">
            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded">Login</button>
        </form>
        <a href="{{ route('password.request') }}" class="text-yellow-600 mt-4 block text-center">Forgot Password?</a>
    </div>
</div>
@endsection