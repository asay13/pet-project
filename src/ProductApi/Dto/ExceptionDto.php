<?php

namespace App\ProductApi\Dto;

readonly class ExceptionDto
{
    public function __construct(
        public string $error
    ){}
}