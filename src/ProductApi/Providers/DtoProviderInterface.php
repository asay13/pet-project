<?php
namespace App\ProductApi\Providers;
interface DtoProviderInterface
{
    public function provide(object $dto): object;
}