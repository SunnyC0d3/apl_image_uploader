@extends('layouts.global-layout')

@section('title', $image['name'])

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 p-6">
    <div class="w-full max-w-lg bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4">Image Preview</h2>

        <div class="flex justify-center">
            <img src="{{ $image['path'] }}" class="w-full max-h-96 object-contain rounded-lg shadow-md" alt="Uploaded Image">
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('index') }}" class="mt-4 inline-block bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">
                Back to Gallery
            </a>
        </div>
    </div>
</div>
@endsection
