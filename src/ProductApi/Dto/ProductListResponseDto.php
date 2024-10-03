<?php

namespace App\ProductApi\Dto;

class ProductListResponseDto
{
    public function __construct(
        public array $productList,
    )
    {
    }
}