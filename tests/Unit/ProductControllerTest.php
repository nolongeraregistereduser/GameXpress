<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $superAdmin;
    protected $productManager;
    protected $regularUser;
    protected $product;
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
        
        // Create a test product
        $this->product = Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'price' => 99,
            'stock' => 10,
            'status' => 'active',
            'category_id' => $this->category->id,
        ]);
    }

  
    public function test_store_product(): void
    {
        Sanctum::actingAs($this->superAdmin);
        
        $productData = [
            'name' => 'New Product',
            'slug' => 'new-product',
            'price' => 149,
            'stock' => 25,
            'status' => 'active',
            'category_id' => $this->category->id,
        ];
        
        $response = $this->postJson('/api/products/create', $productData);
        
        $response->assertStatus(200)
            ->assertJson([
                'status' => '200 Ok',
                'message' => 'Product created successfully',
            ])
            ->assertJsonStructure([
                'status',
                'message',
                'data'
            ]);
            
        $this->assertDatabaseHas('products', [
            'name' => 'New Product',
            'slug' => 'new-product',
        ]);
    }
    
  
    public function test_show_product(): void
    {
        Sanctum::actingAs($this->productManager);
        
        $response = $this->getJson("/api/products/{$this->product->id}");
        
        $response->assertStatus(200)
            ->assertJson([
                'status' => '200 Ok',
                'message' => 'Welcome Super Admin',
            ])
            ->assertJsonStructure([
                'status',
                'message',
                'data'
            ]);
    }
    
 

    

    public function test_validation_errors_when_updating(): void
    {
        Sanctum::actingAs($this->superAdmin);
        
        $response = $this->putJson("/api/products/update/{$this->product->id}", []);
        
        $response->assertStatus(400)
            ->assertJsonValidationErrors(['name', 'slug', 'price', 'stock', 'status']);
    }
    
 
    

    public function test_unauthorized_update_of_product(): void
    {
        Sanctum::actingAs($this->regularUser);
        
        $updatedData = [
            'name' => 'Updated Product',
            'slug' => 'updated-product',
            'price' => 129,
            'stock' => 15,
            'status' => 'active',
        ];
        
        $response = $this->putJson("/api/products/update/{$this->product->id}", $updatedData);
        
        $response->assertStatus(403)
            ->assertJson([
                'status' => '403 Forbidden',
                'message' => 'Unauthorized Access',
            ]);
            
        $this->assertDatabaseMissing('products', [
            'id' => $this->product->id,
            'name' => 'Updated Product',
        ]);
    }
    
 
    
    /**
     * Test unauthorized deletion of product
     */
    public function test_unauthorized_deletion_of_product(): void
    {
        Sanctum::actingAs($this->regularUser);
        
        $response = $this->postJson("/api/products/delete/{$this->product->id}");
        
        $response->assertStatus(403)
            ->assertJson([
                'status' => '403 Forbidden',
                'message' => 'Unauthorized Access',
            ]);
            
        $this->assertDatabaseHas('products', [
            'id' => $this->product->id,
        ]);
    }
    
  
    
    public function test_update_nonexistent_product(): void
    {
        Sanctum::actingAs($this->superAdmin);
        
        $nonExistentId = 9999;
        $updatedData = [
            'name' => 'Updated Product',
            'slug' => 'updated-product',
            'price' => 129,
            'stock' => 15,
            'status' => 'active',
        ];
        
        $response = $this->putJson("/api/products/update/{$nonExistentId}", $updatedData);
        
        $response->assertStatus(404)
            ->assertJson([
                'status' => '404 Not Found',
                'message' => 'Product not found',
            ]);
    }
}