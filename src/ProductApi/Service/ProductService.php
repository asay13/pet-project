<?php

namespace App\ProductApi\Service;

use App\ProductApi\Dto\ExceptionDto;
use App\ProductApi\Dto\ProductListResponseDto;
use App\ProductApi\Dto\ProductResponseDto;
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

    /**
     * @return ProductListResponseDto
     * @throws \Exception
     */
    public function getProductList() :ProductListResponseDto
    {
        $productList = $this->managerRegistry->getRepository(Product::class)->findAll();
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
        $product = $this->managerRegistry->getRepository(Product::class)
            ->findOneBy(['code' => $code]);
        $provider = new ProductToResponseDtoProvider();

        if (!empty($product)) {
            return $provider->provide($product);
        }
        throw new \Exception('Продукт не был найден');
    }
}