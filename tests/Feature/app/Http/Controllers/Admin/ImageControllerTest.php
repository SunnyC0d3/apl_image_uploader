<?php

namespace Tests\Feature\App\Http\Controllers\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;

class ImageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_image_upload_successfully()
    {
        $this->actingAs(User::factory()->create()); // Authenticate a user if necessary

        $file = UploadedFile::fake()->image('test.jpg');

        $response = $this->post(route('auth.images.upload'), [
            'image' => $file,
        ]);

        $response->assertRedirect(route('dashboard'));
    }

    public function test_image_update_successfully()
    {
        $this->actingAs(User::factory()->create());

        $file = UploadedFile::fake()->image('updated.jpg');

        $response = $this->put(route('auth.images.update', ['filename' => 'existing.jpg']), [
            'image' => $file,
        ]);

        $response->assertRedirect(route('dashboard'));
    }

    public function test_image_deletion_successfully()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->delete(route('auth.images.delete', ['filename' => 'image.jpg']));

        $response->assertRedirect(route('dashboard'));
    }
}
