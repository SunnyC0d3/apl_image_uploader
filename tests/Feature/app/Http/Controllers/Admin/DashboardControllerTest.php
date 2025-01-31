<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Classes\HandleImages;
use App\Models\StorageSetting;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Admin\DashboardController;
use Mockery;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        Storage::fake('azure');
    }

    public function test_dashboard_loads_with_images()
    {
        StorageSetting::create(['mode' => 'local']);
    
        $mockHandleImages = Mockery::mock(HandleImages::class);
        $mockHandleImages->shouldReceive('images')->once()->andReturn(['image1.jpg', 'image2.png']);
    
        $controller = new DashboardController($mockHandleImages);
    
        $response = $controller->index();
    
        $this->assertEquals('dashboard', $response->getName());
        $this->assertArrayHasKey('storageMode', $response->getData());
        $this->assertArrayHasKey('images', $response->getData());
        $this->assertEquals('local', $response->getData()['storageMode']);
        $this->assertEquals(['image1.jpg', 'image2.png'], $response->getData()['images']);
    }
    
}
