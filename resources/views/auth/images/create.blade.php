@extends('layouts.global-layout')

@section('title', 'Upload a New Image')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 p-6">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4">Upload a New Image</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-600 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('auth.images.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="image" class="block font-medium text-gray-700 mb-1">Select Image (JPG or PNG)</label>
                <input type="file" name="image" id="image" accept="image/png, image/jpeg" required
                    class="w-full p-3 border rounded focus:ring focus:ring-blue-300">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded transition">
                Upload Image
            </button>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('index') }}" class="text-blue-600 hover:underline">Back to Gallery</a>
        </div>
    </div>
</div>
@endsection
