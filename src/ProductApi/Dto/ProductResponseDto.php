<?php

namespace App\ProductApi\Dto;

class ProductResponseDto
{
    public function __construct(
        public string $name,
        public string $code,
        public string $price,
        public string $colour
    ){}
}