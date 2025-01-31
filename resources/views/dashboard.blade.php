@extends('layouts.global-layout')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-gray-100 min-h-screen">
    <h2 class="text-center text-3xl font-semibold mb-6 text-gray-800">Image Management</h2>

    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-600 rounded" role="alert">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="mb-4 p-3 bg-red-100 text-red-600 rounded">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="text-end mb-3">
        <input type="hidden" name="_storage_setting_token" value="{{ csrf_token() }}" />
        <label for="storage-toggle" class="form-label me-2">Storage Mode:</label>
        <select id="storage-toggle" class="form-select d-inline-block w-auto">
            <option value="local" {{ $storageMode === 'local' ? 'selected' : '' }}>Local</option>
            <option value="azure" {{ $storageMode === 'azure' ? 'selected' : '' }}>Azure</option>
        </select>
    </div>

    <div class="flex justify-end mb-4">
        <a href="{{ route('auth.images.create') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow transition">
            Upload Image
        </a>
    </div>

    @if ($images->isEmpty())
    <div class="bg-blue-100 text-blue-700 p-4 text-center rounded-lg">
        No images uploaded yet.
    </div>
    @else
    <div class="overflow-x-auto bg-white shadow-md rounded-lg p-4">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-800 text-white text-left">
                    <th class="p-3">#</th>
                    <th class="p-3">Image</th>
                    <th class="p-3">Filename</th>
                    <th class="p-3">Uploaded At</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($images as $index => $image)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $index + 1 }}</td>
                    <td class="p-3">
                        <img src="{{ $image['path'] }}" alt="Image" class="w-16 h-16 object-cover rounded">
                    </td>
                    <td class="p-3">{{ basename($image['name']) }}</td>
                    @if(isset($image['created_at']))
                    <td class="p-3">{{ date('d-m-Y', strtotime($image['created_at'])) }}</td>
                    @else
                    <td class="p-3"></td>
                    @endif
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('auth.images.edit', ['filename' => $image['name']]) }}"
                            class="px-3 py-1 bg-blue-600 text-white text-sm rounded shadow hover:bg-blue-700 transition">
                            Edit
                        </a>
                        <form action="{{ route('auth.images.delete', ['filename' => $image['name']]) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this image?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-3 py-1 bg-red-600 text-white text-sm rounded shadow hover:bg-red-700 transition">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex justify-center">
        {{ $images->links('pagination::tailwind') }}
    </div>
    @endif
</div>
@endsection