<?php

namespace App\Http\Controllers\Admin;

use App\Models\StorageSetting;
use App\Classes\HandleImages;
use \Exception;
use Illuminate\Support\Facades\Log;

class DashboardController
{
    private $handleImages;

    public function __construct(HandleImages $handleImages)
    {
        $this->handleImages = $handleImages;
    }

    public function index()
    {
        try {
            $storageMode = StorageSetting::getMode();
            $images = $this->handleImages->images();
    
            return view('dashboard', compact('storageMode', 'images'));
        } catch (Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred']);
        }
    }
}
