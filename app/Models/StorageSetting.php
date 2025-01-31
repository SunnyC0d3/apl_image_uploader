<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class StorageSetting extends Model
{
    protected $fillable = ['mode'];

    /**
     * Retrieve the first storage mode from cache or DB.
     */
    public static function getMode(): string
    {
        return Cache::rememberForever('storage_mode', function () {
            return self::first()?->mode ?? 'local';
        });
    }

    /**
     * Update storage mode and refresh cache.
     */
    public static function setMode(string $mode): void
    {
        if (!in_array($mode, ['local', 'azure'])) {
            throw new \InvalidArgumentException("Invalid storage mode. Allowed values: 'local', 'azure'.");
        }

        self::updateOrCreate(['id' => 1], ['mode' => $mode]);
        Cache::forever('storage_mode', $mode);
    }
}
