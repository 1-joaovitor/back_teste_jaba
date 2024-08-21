<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ApiRoutesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_login_a_user()
    {
        $user = User::factory()->create([
            'password' => Hash::make('123'),
        ]);

        $loginData = [
            'email' => $user->email,
            'password' => '123',
        ];

        $response = $this->postJson('/api/login', $loginData); 

        $response->assertStatus(200)
                 ->assertJsonStructure(['acessToken']);
    }

    public function it_can_access_profile_with_valid_token()
    {
        $user = User::factory()->create([
            'password' => Hash::make('123'),
        ]);

        $loginResponse = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => '123',
        ]);

        $token = $loginResponse->json('token');

        $response = $this->withToken($token)->getJson('/api/profile'); 

        $response->assertStatus(200)
                 ->assertJson([
                     'email' => $user->email,
                 ]);
    }
}
