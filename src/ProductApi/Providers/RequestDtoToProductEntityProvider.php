<?php

namespace App\ProductApi\Providers;

use App\ProductApi\Entity\Product;

class RequestDtoToProductEntityProvider implements DtoProviderInterface
{
    public function provide(object $dto) :object
    {
        $product = new Product();
        $product->setName($dto->name)
            ->setPrice($dto->price)
            ->setCode($dto->code)
            ->setColour($dto->colour);
           // ->setDescription($dto->description);
        return $product;
    }
}