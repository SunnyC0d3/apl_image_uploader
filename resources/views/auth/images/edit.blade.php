@extends('layouts.global-layout')

@section('title', 'Edit Image')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 p-6">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4">Edit Image</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-600 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('auth.images.update', ['filename' => $image['name']]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="text-center mb-4">
                <img src="{{ $image['path'] }}" class="w-48 h-48 object-cover rounded-lg shadow-md" alt="Current Image">
            </div>

            <div class="mb-4">
                <label for="image" class="block font-medium text-gray-700 mb-1">Select New Image (Optional)</label>
                <input type="file" name="image" id="image" accept="image/png, image/jpeg"
                    class="w-full p-3 border rounded focus:ring focus:ring-blue-300">
                <small class="text-gray-500">Leave blank to keep the current image.</small>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                Update Image
            </button>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('index') }}" class="text-blue-600 hover:underline">Back to Gallery</a>
        </div>
    </div>
</div>
@endsection
