<?php

namespace App\ProductApi\Service;

use App\ProductApi\Dto\ProductListResponseDto;
use App\ProductApi\Entity\Product;
use App\ProductApi\Providers\ProductToResponseDtoProvider;
use App\ProductApi\Providers\RequestDtoToProductEntityProvider;
use Doctrine\Persistence\ManagerRegistry;

class ProductService
{
    private ManagerRegistry $managerRegistry;
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function createProduct(
        $productReview
    )
    {
        $provider = new RequestDtoToProductEntityProvider();
        $product = $provider->provide($productReview);
        $entityManager = $this->managerRegistry->getManager();
        $entityManager->persist($product);
        $entityManager->flush();
        return $product;
    }

    public function getProductList() :ProductListResponseDto
    {
        $productList = $this->managerRegistry->getRepository(Product::class)->findAll();;
        $provider = new ProductToResponseDtoProvider();
        $arrProductList = [];
        foreach ($productList as $product){
            $arrProductList[] = $provider->provide($product);
        }
        return new ProductListResponseDto($arrProductList);
    }
    public function getProductByCode(string $code) :ProductListResponseDto
    {
        $productList = $this->managerRegistry->getRepository(Product::class)->findAll();;
        $provider = new ProductToResponseDtoProvider();
        $arrProductList = [];
        foreach ($productList as $product){
            $arrProductList[] = $provider->provide($product);
        }
        return new ProductListResponseDto($arrProductList);
    }
}