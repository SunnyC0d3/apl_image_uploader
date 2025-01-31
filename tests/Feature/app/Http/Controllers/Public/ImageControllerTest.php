<?php

namespace Tests\Feature\App\Http\Controllers\Public;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Mockery;
use App\Classes\HandleImages;
use App\Http\Controllers\Public\ImageController;
use Tests\TestCase;

class ImageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_show_returns_view_with_image_url()
    {
        $handleImagesMock = Mockery::mock(HandleImages::class);
        $handleImagesMock->shouldReceive('getImageUrl')
                         ->once()
                         ->with('image1.jpg')
                         ->andReturn('https://example.com/images/image1.jpg');

        $controller = new ImageController($handleImagesMock);

        $response = $controller->show('image1.jpg');

        $this->assertEquals('images.show', $response->getName());
        $this->assertEquals('https://example.com/images/image1.jpg', $response->getData()['image']);
    }
}
