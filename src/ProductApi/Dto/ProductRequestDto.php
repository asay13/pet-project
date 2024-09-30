<?php

namespace App\ProductApi\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class ProductRequestDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 3, max: 500)]
        public readonly string $name,

        #[Assert\NotBlank]
        #[Assert\Length(min: 3, max: 500)]
        public readonly string $code,

        #[Assert\NotBlank]
        #[Assert\Positive()]
        public readonly string $price,

        #[Assert\Length(min: 3, max: 500)]
        public readonly string $colour,

       // public readonly string $description,
    ) {
    }
}