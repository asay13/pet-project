<?php

namespace App\ProductApi\Service;

use App\ProductApi\Dto\ExceptionDto;
use App\ProductApi\Dto\ProductListResponseDto;
use App\ProductApi\Dto\ProductResponseDto;
use App\ProductApi\Entity\Product;
use App\ProductApi\Providers\ProductToResponseDtoProvider;
use App\ProductApi\Providers\RequestDtoToProductEntityProvider;
use App\ProductApi\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductService
{
    private ProductRepository $productRepository;
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function createProduct(
        $productReview
    )
    {
        $provider = new RequestDtoToProductEntityProvider();
        $product = $provider->provide($productReview);
        $this->productRepository->add($product);
        return $product;
    }

    /**
     * @return ProductListResponseDto
     * @throws \Exception
     */
    public function getProductList() :ProductListResponseDto
    {
        $productList = $this->productRepository->findAll();
        $provider = new ProductToResponseDtoProvider();
        $arrProductList = [];
        foreach ($productList as $product){
            $arrProductList[] = $provider->provide($product);
        }
        if (!empty($arrProductList)) {
            return new ProductListResponseDto($arrProductList);
        }
        throw new \Exception("Продукты не найдены");
    }

    /**
     * @param string $code
     * @return ProductResponseDto
     * @throws \Exception
     */
    public function getProductByCode(string $code) :ProductResponseDto
    {
        $product = $this->productRepository->findOneBy(['code' => $code]);
        $provider = new ProductToResponseDtoProvider();

        if (!empty($product)) {
            return $provider->provide($product);
        }
        throw new \Exception('Продукт не был найден');
    }
}