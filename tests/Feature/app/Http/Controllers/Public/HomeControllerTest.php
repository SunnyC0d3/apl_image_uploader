<?php

namespace Tests\Feature\App\Http\Controllers\Public;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Mockery;
use App\Classes\HandleImages;
use App\Http\Controllers\Public\HomeController;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_index_returns_view_with_images()
    {
        $handleImagesMock = Mockery::mock(HandleImages::class);
        $handleImagesMock->shouldReceive('images')->once()->andReturn(['image1.jpg', 'image2.png']);

        $controller = new HomeController($handleImagesMock);

        $response = $controller->index();

        $this->assertEquals('welcome', $response->getName());
        $this->assertEquals(['image1.jpg', 'image2.png'], $response->getData()['images']);
    }
}
