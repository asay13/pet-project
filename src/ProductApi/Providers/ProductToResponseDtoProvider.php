<?php

namespace App\ProductApi\Providers;

use App\ProductApi\Dto\ProductResponseDto;
use App\ProductApi\Entity\Product;
class ProductToResponseDtoProvider implements EntityProviderInterface
{
     public function provide(object $entity): object
     {
         return new ProductResponseDto(
             $entity->getName(),
             $entity->getCode(),
             $entity->getPrice(),
             $entity->getColour(),
         );
     }
}