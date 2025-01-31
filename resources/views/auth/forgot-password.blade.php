@extends('layouts.global-layout')

@section('title', 'Forgot Password')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Reset Password</h2>
        @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-600 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Enter your email" class="w-full p-3 border rounded mb-3">
            <button type="submit" class="w-full bg-yellow-600 text-white py-2 rounded">Send Reset Link</button>
        </form>
    </div>
</div>
@endsection