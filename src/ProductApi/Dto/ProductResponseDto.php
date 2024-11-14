<?php

namespace App\ProductApi\Dto;

readonly class ProductResponseDto
{
    public function __construct(
        public string $name,
        public string $code,
        public string $price,
        public string $colour
    ){}
}