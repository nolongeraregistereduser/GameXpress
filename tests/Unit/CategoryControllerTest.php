<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $superAdmin;
    protected $productManager;
    protected $regularUser;
    protected $category;

    public function setUp(): void
    {
        parent::setUp();
        
        // Create roles
        Role::create(['name' => 'super_admin']);
        Role::create(['name' => 'product_manager']);
        Role::create(['name' => 'user_manager']);
        
        // Create test users
        $this->superAdmin = User::factory()->create();
        $this->superAdmin->assignRole('super_admin');
        
        $this->productManager = User::factory()->create();
        $this->productManager->assignRole('product_manager');
        
        $this->regularUser = User::factory()->create();
        $this->regularUser->assignRole('user_manager');
        
        // Create a test category
        $this->category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
        ]);
    }

 
    public function test_store_category_with_valid_data(): void
    {
        Sanctum::actingAs($this->superAdmin);
        
        $categoryData = [
            'name' => 'New Category',
            'slug' => 'new-category',
        ];
        
        $response = $this->postJson('/api/categories/create', $categoryData);
        
        $response->assertStatus(200)
                ->assertJson([
                    'status' => '200 Ok',
                    'message' => 'Category created successfully',
                ])
                ->assertJsonStructure([
                    'status',
                    'message',
                    'data' => [
                        'name',
                        'slug',
                        'id',
                    ]
                ]);
                
        $this->assertDatabaseHas('categories', [
            'name' => 'New Category',
            'slug' => 'new-category',
        ]);
    }
    
    

    public function test_show_nonexistent_category(): void
    {
        Sanctum::actingAs($this->superAdmin);
        
        $nonExistentId = 9999;
        
        $response = $this->getJson("/api/categories/{$nonExistentId}");
        
        $response->assertStatus(200)
                ->assertJson([
                    'status' => '404 Not Found',
                    'message' => 'Category not found',
                ]);
    }
    

    

    public function test_update_category_with_authorized_user(): void
    {
        Sanctum::actingAs($this->productManager);
        
        $updatedData = [
            'name' => 'Updated Category',
            'slug' => 'updated-category',
        ];
        
        $response = $this->putJson("/api/categories/update/{$this->category->id}", $updatedData);
        
        $response->assertStatus(200)
                ->assertJson([
                    'status' => '200 Ok',
                    'message' => 'Product updated successfully',
                ])
                ->assertJsonStructure([
                    'status',
                    'message',
                    'data' => [
                        'id',
                        'name',
                        'slug',
                    ]
                ]);
                
        $this->assertDatabaseHas('categories', [
            'id' => $this->category->id,
            'name' => 'Updated Category',
            'slug' => 'updated-category',
        ]);
    }
    

    public function test_update_category_with_unauthorized_user(): void
    {
        Sanctum::actingAs($this->regularUser);
        
        $updatedData = [
            'name' => 'Updated Category',
            'slug' => 'updated-category',
        ];
        
        $response = $this->putJson("/api/categories/update/{$this->category->id}", $updatedData);
        
        $response->assertStatus(403)
                ->assertJson([
                    'status' => '403 Forbidden',
                    'message' => 'Unauthorized Access',
                ]);
                
        $this->assertDatabaseMissing('categories', [
            'id' => $this->category->id,
            'name' => 'Updated Category',
        ]);
    }
    
 
    public function test_update_nonexistent_category(): void
    {
        Sanctum::actingAs($this->superAdmin);
        
        $nonExistentId = 9999;
        $updatedData = [
            'name' => 'Updated Category',
            'slug' => 'updated-category',
        ];
        
        $response = $this->putJson("/api/categories/update/{$nonExistentId}", $updatedData);
        
        $response->assertStatus(404)
                ->assertJson([
                    'status' => '404 Not Found',
                    'message' => 'Product not found',
                ]);
    }
    

    public function test_update_category_with_invalid_data(): void
    {
        Sanctum::actingAs($this->superAdmin);
        
        $response = $this->putJson("/api/categories/update/{$this->category->id}", []);
        
        $response->assertStatus(400)
                ->assertJsonValidationErrors(['name', 'slug']);
    }
    

    public function test_destroy_category_with_authorized_user(): void
    {
        Sanctum::actingAs($this->superAdmin);
        
        $response = $this->postJson("/api/categories/delete/{$this->category->id}");
        
        $response->assertStatus(200)
                ->assertJson([
                    'status' => '200 Ok',
                    'message' => 'Product deleted successfully',
                ]);
                
        $this->assertDatabaseMissing('categories', [
            'id' => $this->category->id,
        ]);
    }
    

    public function test_destroy_category_with_unauthorized_user(): void
    {
        Sanctum::actingAs($this->regularUser);
        
        $response = $this->postJson("/api/categories/delete/{$this->category->id}");
        
        $response->assertStatus(403)
                ->assertJson([
                    'status' => '403 Forbidden',
                    'message' => 'Unauthorized Access',
                ]);
                
        $this->assertDatabaseHas('categories', [
            'id' => $this->category->id,
        ]);
    }
    

    public function test_destroy_nonexistent_category(): void
    {
        Sanctum::actingAs($this->superAdmin);
        
        $nonExistentId = 9999;
        
        $response = $this->postJson("/api/categories/delete/{$nonExistentId}");
        
        $response->assertStatus(404)
                ->assertJson([
                    'status' => '404 Not Found',
                    'message' => 'Product not found',
                ]);
    }
}