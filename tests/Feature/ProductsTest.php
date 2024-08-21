<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        Product::factory()->count(5)->create();
    }

    /** @test */
    public function it_can_list_products()
    {
        $response = $this->actingAs($this->user, 'sanctum')->get('/api/products');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     '*' => [
                         'id',
                         'name',
                         'registration_date',
                         'price',
                         'user_id',
                         'categories' => [
                             '*' => [
                                 'id',
                                 'name'
                             ]
                         ]
                     ]
                 ]);
    }


}
