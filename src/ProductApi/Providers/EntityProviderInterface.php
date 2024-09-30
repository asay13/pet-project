<?php
namespace App\ProductApi\Providers;
interface EntityProviderInterface
{
    public function provide(object $entity): object;
}