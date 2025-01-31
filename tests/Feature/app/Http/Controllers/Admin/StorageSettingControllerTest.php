<?php

namespace Tests\Feature\App\Http\Controllers\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\StorageSetting;

class StorageSettingControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        StorageSetting::create(['mode' => 'local']);
    }

    public function test_storage_mode_update_successfully()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->post(route('auth.storage.update'), [
            'mode' => 'azure',
        ]);

        $response->assertJson([
            'success' => true,
            'message' => 'Storage mode updated successfully!',
        ]);

        $this->assertDatabaseHas('storage_settings', ['mode' => 'azure']);
    }

    public function test_invalid_storage_mode_fails_validation()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->post(route('auth.storage.update'), [
            'mode' => 'invalid_mode',
        ]);

        $response->assertSessionHasErrors(['mode']);
    }
}
