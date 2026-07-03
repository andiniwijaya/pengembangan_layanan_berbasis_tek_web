<?php

namespace Tests\Feature\Profile;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_profile(): void
    {
        $this->get(route('profile.edit'))->assertRedirect(route('login'));
    }

    public function test_customer_can_update_profile(): void
    {
        $user = User::factory()->create(['name' => 'Old Name']);

        $this->actingAs($user)->put(route('profile.update'), [
            'name' => 'New Name',
            'email' => $user->email,
            'phone' => '08111111111',
            'address' => 'New Address',
        ])->assertRedirect();

        $this->assertSame('New Name', $user->fresh()->name);
    }

    public function test_customer_can_upload_avatar(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user)->put(route('profile.update'), [
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => UploadedFile::fake()->image('avatar.jpg'),
        ])->assertRedirect();

        $this->assertNotNull($user->fresh()->avatar);
        Storage::disk('public')->assertExists($user->fresh()->avatar);
    }
}
