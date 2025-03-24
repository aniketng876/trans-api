<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\ProductService;
use App\Repositories\ProductRepository;
use App\BO\ProductBO;
use App\DAO\ProductDAO;
use Illuminate\Support\Facades\Cache;
use Mockery;

class ProductServiceTest extends TestCase
{
    private $productService;
    private $productRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock ProductRepository
        $this->productRepositoryMock = Mockery::mock(ProductRepository::class);
        $this->productService = new ProductService($this->productRepositoryMock);
    }

    /** @test */
    public function it_should_return_all_products()
    {
        $products = [['id' => 1, 'name' => 'Laptop'], ['id' => 2, 'name' => 'Phone']];

        $this->productRepositoryMock
            ->shouldReceive('getAll')
            ->with(null, null)
            ->once()
            ->andReturn($products);

        $result = $this->productService->getAllProducts(null, null);

        $this->assertCount(2, $result);
        $this->assertEquals($products, $result);
    }

    /** @test */
    public function it_should_return_a_product_by_id()
    {
        $productDAO = new ProductDAO(1, 'Laptop', 'Gaming Laptop', 1500, 1);

        $this->productRepositoryMock
            ->shouldReceive('getById')
            ->with(1)
            ->once()
            ->andReturn($productDAO); // 🔹 Return a ProductDAO object, not an array.

        $result = $this->productService->getProductById(1);

        $this->assertEquals((array) $productDAO, $result);
    }


    /** @test */
    public function it_should_return_null_if_product_not_found()
    {
        $this->productRepositoryMock
            ->shouldReceive('getById')
            ->with(99)
            ->once()
            ->andReturn(null);

        $result = $this->productService->getProductById(99);

        $this->assertNull($result);
    }

    /** @test */
    public function it_should_create_a_product()
    {
        $productDAO = new ProductDAO(0, 'Laptop', 'Gaming Laptop', 1500, 1);

        $productBO = new ProductBO($productDAO);

        $createdProductDAO = new ProductDAO(1, 'Laptop', 'Gaming Laptop', 1500, 1);

        $this->productRepositoryMock
            ->shouldReceive('create')
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof ProductDAO;
            }))
            ->once()
            ->andReturn($createdProductDAO); // 🔹 Return a ProductDAO object

        Cache::shouldReceive('forget')->once()->with('products:category_1');

        $result = $this->productService->createProduct($productBO);

        $this->assertEquals((array) $createdProductDAO, $result);
    }

    /** @test */
    public function it_should_update_a_product()
    {
        $productDAO = new ProductDAO(1, 'Updated Laptop', 'Updated Gaming Laptop', 1600, 1);

        $productBO = new ProductBO($productDAO);

        $this->productRepositoryMock
            ->shouldReceive('update')
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof ProductDAO;
            }), 1)
            ->once()
            ->andReturn($productDAO);
        Cache::shouldReceive('forget')->once()->with('products:category_1');

        $result = $this->productService->updateProduct($productBO, 1);
        $this->assertEquals((array) $productDAO, $result);
    }


    /** @test */
    public function it_should_return_null_when_updating_a_non_existing_product()
    {
        $productDAO = new ProductDAO(999, 'Non-existing Product', 'No description', 0, 1);

        $productBO = new ProductBO($productDAO);

        $this->productRepositoryMock
            ->shouldReceive('update')
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof ProductDAO;
            }), 999)
            ->once()
            ->andReturn(null);

        Cache::shouldReceive('forget')->once()->with('products:category_1');

        $result = $this->productService->updateProduct($productBO, 999);

        $this->assertNull($result);
    }


    /** @test */
    public function it_should_delete_a_product()
    {
        $productDAO = new ProductDAO(1, 'Gaming Laptop', 'High-end laptop', 1500, 1);

        $this->productRepositoryMock
            ->shouldReceive('getById')
            ->with(1)
            ->once()
            ->andReturn($productDAO); 

        $this->productRepositoryMock
            ->shouldReceive('delete')
            ->with(1)
            ->once()
            ->andReturn(true);

        Cache::shouldReceive('forget')->once()->with('products_list');

        $result = $this->productService->deleteProduct(1);

        $this->assertTrue($result);
    }


    /** @test */
    public function it_should_return_false_when_deleting_a_non_existing_product()
    {
        $this->productRepositoryMock
            ->shouldReceive('getById')
            ->with(99)
            ->once()
            ->andReturn(null);

        Cache::shouldReceive('forget')->once()->with('products_list');

        $result = $this->productService->deleteProduct(99);

        $this->assertFalse($result);
    }
}
