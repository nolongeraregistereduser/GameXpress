<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $superAdmin;
    protected $userManager;
    protected $regularUser;
    protected $testUser;

    public function setUp(): void
    {
        parent::setUp();
        
        // Create roles
        Role::create(['name' => 'super_admin']);
        Role::create(['name' => 'user_manager']);
        Role::create(['name' => 'product_manager']);
        
        // Create test users
        $this->superAdmin = User::factory()->create();
        $this->superAdmin->assignRole('super_admin');
        
        $this->userManager = User::factory()->create();
        $this->userManager->assignRole('user_manager');
        
        $this->regularUser = User::factory()->create();
        $this->regularUser->assignRole('product_manager');
        
        // Create a test user to be managed
        $this->testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
        ]);
        $this->testUser->assignRole('product_manager');
    }

   


 
    public function test_store_user_with_invalid_data(): void
    {
        Sanctum::actingAs($this->userManager);
        
        $response = $this->postJson('/api/users/create', [
            'name' => '',
            'email' => 'not-an-email',
            'password' => 'short',
        ]);
        
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Validation failed',
            ])
            ->assertJsonStructure([
                'message',
                'errors'
            ]);
            
        $this->assertDatabaseMissing('users', [
            'email' => 'not-an-email',
        ]);
    }



    public function test_delete_nonexistent_user(): void
    {
        Sanctum::actingAs($this->superAdmin);
        
        $nonExistentId = 999999;
        
        $response = $this->deleteJson("/api/users/delete/{$nonExistentId}");
        
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'User not found',
            ]);
    }




    public function delete_user_valid_data(): void
    {
        Sanctum::actingAs($this->superAdmin);

        $response = $this->deleteJson("/api/users/delete/{$this->testUser->id}");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'User deleted successfully',
            ]);

        $this->assertDatabaseMissing('users', [
            'id' => $this->testUser->id,
        ]);
    }
    


}