<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Images\ImageUploadRequest;
use App\Classes\HandleImages;
use App\Http\Requests\Images\ImageUpdateRequest;
use \Exception;
use Illuminate\Support\Facades\Log;

class ImageController
{
    private $handleImages;

    public function __construct(HandleImages $handleImages)
    {
        $this->handleImages = $handleImages;
    }

    public function create()
    {
        try {
            return view('auth.images.create');
        } catch (Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred']);
        }
    }

    public function store(ImageUploadRequest $request)
    {
        $request->validated();

        try {
            $this->handleImages->upload($request->file('image'));

            return redirect()->route('dashboard')->with('success', 'Image uploaded successfully!');
        } catch (Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred']);
        }
    }

    public function edit(string $filename)
    {
        try {
            $image = $this->handleImages->getImageUrl($filename);
            return view('auth.images.edit', compact('image'));
        } catch (Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred']);
        }
    }

    public function update(ImageUpdateRequest $request, string $filename)
    {
        $request->validated();

        try {
            if ($request->hasFile('image')) {
                $this->handleImages->update($request->file('image'), $filename);
            }

            return redirect()->route('dashboard')->with('success', 'Image updated successfully!');
        } catch (Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred']);
        }
    }

    public function destroy(string $filename)
    {
        try {
            $this->handleImages->delete($filename);

            return redirect()->route('dashboard')->with('success', 'Image deleted successfully!');
        } catch (Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred']);
        }
    }
}
