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

    /**
     * Show the image upload form.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function create()
    {
        try {
            return view('auth.images.create');
        } catch (Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred']);
        }
    }

    /**
     * Handle image upload and store it.
     *
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
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

    /**
     * Show the image edit form.
     *
     * @param string $filename
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
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

    /**
     * Update an existing image.
     *
     * @param ImageUpdateRequest $request
     * @param string $filename
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
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

    /**
     * Delete an image.
     *
     * @param string $filename
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
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
