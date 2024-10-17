<?php

namespace App\ProductApi\Controller;

use App\ProductApi\Dto\ProductRequestDto;
use App\ProductApi\Entity\Product;
use App\ProductApi\Providers\RequestDtoToProductEntityProvider;
use App\ProductApi\Service\ProductService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsController]
class ProductsController
{

    private ValidatorInterface $validator;
    private ProductService $productService;

    public function __construct(
        ValidatorInterface $validator,
        ProductService $productService
    )
    {
        $this->validator = $validator;
        $this->productService = $productService;
    }
//    #[Route(path: '/test-products', name: 'test_products')]
//    public function test()
//    {
//        try {
//            $host = 'empty-symfony-database-1';
//            $port = 5432;
//            $dbname = 'app';
//            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
//            $username = 'app';
//            $passwd = '!ChangeMe!';
//            $dbconn = new \PDO($dsn, $username, $passwd);
//        } catch (\PDOException $e) {
//            print "Error!: " . $e->getMessage() . "<br />";
//        }
//        // Выполним тестовый SQL запрос
//        try {
//            $sql = 'Select * FROM pg_database';
//            echo '<pre>';
//
//            foreach ($dbconn->query($sql) as $row) {
//                print_r($row);
//            }
//        } catch (\PDOException $e) {
//            print "Error!: " . $e->getMessage() . "<br />";
//        }
//    }

    #[Route(path: '/products/list', name: 'get_products')]
    public function getProducts()
    {
        $productList = $this->productService->getProductList();
        return new Response(json_encode($productList));

    }

    #[Route(path: '/products/create', name: 'create_product')]
    public function createProduct(
        #[MapRequestPayload] ProductRequestDto $productReview
        ): Response
    {

        $errors = $this->validator->validate($productReview);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
                return new Response($errorsString);
            }

        $product = $this->productService->createProduct($productReview);
        return new Response('Saved new product with id ' . $product->getId());
    }

    #[Route(path: '/products/list/{code}', name: 'get_product_by_code')]
    public function getProductByCode(string $code)
    {
        $productList = $this->productService->getProductList();
        return new Response(json_encode($productList));

    }
}