<?php

namespace App\Http\Controllers\Admin;

use App\Models\StorageSetting;
use App\Http\Requests\StorageSetting\UpdateStorageSettingRequest;
use \Exception;
use Illuminate\Support\Facades\Log;

class StorageSettingController
{
    /**
     * Update storage mode.
     *
     * @param UpdateStorageSettingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateStorageSettingRequest $request)
    {
        $request->validated();

        try {
            StorageSetting::setMode($request->mode);
            return response()->json(['success' => true, 'message' => 'Storage mode updated successfully!']);
        } catch (Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred']);
        }
    }
}
