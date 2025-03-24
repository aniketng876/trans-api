<?php

namespace Tests\Unit\Repositories;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $productRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->productRepository = new ProductRepository(new Product());
    }

    /** @test */
    public function it_should_fetch_all_products()
    {
        Product::factory()->count(3)->create();
        $result = $this->productRepository->getAll();
        $this->assertCount(3, $result);
    }

    /** @test */
    public function it_should_fetch_a_product_by_id()
    {
        $product = Product::factory()->create();
        $result = $this->productRepository->findById($product->id);
        $this->assertEquals($product->id, $result->id);
    }

    /** @test */
    public function it_should_create_a_new_product()
    {
        $data = ['name' => 'Test Product', 'description' => 'Test Description', 'price' => 100];
        $product = $this->productRepository->create($data);
        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }

    /** @test */
    public function it_should_update_a_product()
    {
        $product = Product::factory()->create();
        $updatedData = ['name' => 'Updated Name'];
        $this->productRepository->update($product->id, $updatedData);
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Updated Name']);
    }

    /** @test */
    public function it_should_delete_a_product()
    {
        $product = Product::factory()->create();
        $this->productRepository->delete($product->id);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
