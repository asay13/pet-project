<?php

namespace App\Tests\ProductApi\Service;

use App\ProductApi\Dto\ProductListResponseDto;
use App\ProductApi\Dto\ProductRequestDto;
use App\ProductApi\Dto\ProductResponseDto;
use App\ProductApi\Entity\Product;
use App\ProductApi\Repository\ProductRepository;
use App\ProductApi\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
class ProductServiceTest extends WebTestCase
{

    private $repository;
    private ProductRequestDto $productDataDTO;
    private Product $productData;

    public function setUp(): void
    {
        self::bootKernel();
        $this->initStubs();
    }

    public function testCreateProduct(): void
    {
        $service = new ProductService($this->repository);

        $testProduct = $service->createProduct($this->productDataDTO);
        $this->assertInstanceOf(Product::class, $testProduct);
        $this->assertEquals($testProduct->getName(), $this->productDataDTO->name);
        $this->assertEquals($testProduct->getCode(), $this->productDataDTO->code);
        $this->assertEquals($testProduct->getPrice(), $this->productDataDTO->price);
        $this->assertEquals($testProduct->getColour(), $this->productDataDTO->colour);
    }

    /**
     * @return void
     */
    public function testGetProductListException(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Продукты не найдены");
        $service = new ProductService($this->repository);
        $service->getProductList();
    }

    public function testGetProductList(): void
    {
        $this->setProductRepositoryMocks();
        $service = new ProductService($this->repository);
        $testProductList = $service->getProductList();
        $this->assertInstanceOf(ProductListResponseDto::class, $testProductList);
        foreach ($testProductList->productList as $product) {
            $this->assertInstanceOf(ProductResponseDto::class, $product);
            $this->assertEquals($product->name, $this->productDataDTO->name);
            $this->assertEquals($product->code, $this->productDataDTO->code);
            $this->assertEquals($product->price, $this->productDataDTO->price);
            $this->assertEquals($product->colour, $this->productDataDTO->colour);
        }
    }


    /**
     * @return void
     */
    public function testGetProductByCodeException(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Продукт не был найден');
        $service = new ProductService($this->repository);
        $service->getProductByCode($this->productDataDTO->code);
    }

    public function testGetProductByCodeList(): void
    {
        $this->setProductRepositoryMocks();
        $service = new ProductService($this->repository);
        $testProduct = $service->getProductByCode($this->productDataDTO->code);

        $this->assertInstanceOf(ProductResponseDto::class, $testProduct);
        $this->assertEquals($testProduct->name, $this->productDataDTO->name);
        $this->assertEquals($testProduct->code, $this->productDataDTO->code);
        $this->assertEquals($testProduct->price, $this->productDataDTO->price);
        $this->assertEquals($testProduct->colour, $this->productDataDTO->colour);

    }

    private function initStubs(): void
    {
        $this->productDataDTO = new ProductRequestDto(
            name: 'Test Product',
            code: 'test_product',
            price: 1000,
            colour: 'test_colour'
        );
        $this->productData = (new Product())
            ->setId(1)
            ->setName($this->productDataDTO->name)
            ->setCode($this->productDataDTO->code)
            ->setPrice($this->productDataDTO->price)
            ->setColour($this->productDataDTO->colour);

        $this->repository = $this->createMock(ProductRepository::class);

    }

    private function setProductRepositoryMocks()
    {
        $this->repository->expects($this->any())->method('findAll')->willReturn([$this->productData]);
        $this->repository->expects($this->any())->method('findOneBy')->willReturn($this->productData);
    }

}