@extends('layouts.global-layout')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 py-10">
    <div class="w-full max-w-4xl text-center">
        <h1 class="text-5xl font-bold text-gray-800">Welcome to Our Platform</h1>
        <p class="mt-4 text-lg text-gray-600">A simple, clean, and modern experience.</p>
    </div>
    <div class="mt-6">
        @auth
        <a href="{{ route('auth.images.create') }}" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition">Upload</a>
        @else
        <a href="{{ route('login') }}" class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition">Login</a>
        @endauth
    </div>

    @if ($images->isEmpty())
    <div class="mt-10 bg-blue-100 text-blue-700 p-4 text-center rounded-lg">
        No images uploaded yet.
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-10 px-4">
        @foreach ($images as $image)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <a href="{{ route('images.show', ['filename' => $image['name']]) }}">
                <img src="{{ $image['path'] }}" class="w-full h-60 object-cover" alt="Uploaded Image">
            </a>
            <div class="p-4 text-center">
                <p class="text-gray-600 text-sm">{{ $image['name'] }}</p>
                @if(isset($image['created_at']))
                <p class="text-gray-600 text-sm">Uploaded on: {{ date('d-m-Y', strtotime($image['created_at'])) }}</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $images->links('pagination::tailwind') }}
    </div>
    @endif
</div>
@endsection