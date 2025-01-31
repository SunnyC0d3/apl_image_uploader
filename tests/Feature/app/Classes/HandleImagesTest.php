<?php

namespace Tests\Feature\App\Classes;

use App\Classes\HandleImages;
use App\Models\StorageSetting;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Tests\TestCase;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Intervention\Image\Drivers\Gd\Driver;

class HandleImagesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        Storage::fake('azure');
    }

    public function test_it_can_upload_an_image_to_local_storage()
    {
        StorageSetting::create(['mode' => 'local']);
        $imageManager = new ImageManager(Driver::class);

        $file = \Illuminate\Http\UploadedFile::fake()->image('test.jpg', 500, 500);
        $handleImages = new HandleImages($imageManager);
        $handleImages->upload($file);

        Storage::disk('public')->assertExists('uploads/' . time() . '.jpg');
    }

    public function test_it_throws_exception_for_large_images()
    {
        StorageSetting::create(['mode' => 'local']);
        $imageManager = new ImageManager(Driver::class);

        $file = \Illuminate\Http\UploadedFile::fake()->image('test.jpg', 2000, 2000);
        $handleImages = new HandleImages($imageManager);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Image dimensions should not exceed 1024x1024.');

        $handleImages->upload($file);
    }
}
