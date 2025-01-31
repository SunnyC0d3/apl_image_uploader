<?php

namespace App\Http\Controllers\Public;

use App\Classes\HandleImages;
use \Exception;
use Illuminate\Support\Facades\Log;

class HomeController
{
    private $handleImages;

    public function __construct(HandleImages $handleImages)
    {
        $this->handleImages = $handleImages;
    }

    public function index()
    {
        try {
            $images = $this->handleImages->images();
            return view('welcome', compact('images'));
        } catch (Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred']);
        }
    }
}
