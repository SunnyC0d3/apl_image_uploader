<?php

namespace App\Http\Controllers\Public;

use App\Classes\HandleImages;
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
     * Show an image by filename.
     *
     * @param string $filename
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function show(string $filename)
    {
        try {
            $image = $this->handleImages->getImageUrl($filename);
            return view('images.show', compact('image'));
        } catch (Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred']);
        }
    }
}
