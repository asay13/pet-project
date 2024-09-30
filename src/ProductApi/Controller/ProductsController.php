<?php

namespace App\ProductApi\Controller;

use App\ProductApi\Dto\ProductRequestDto;
use App\ProductApi\Entity\Product;
use App\ProductApi\Providers\RequestDtoToProductEntityProvider;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsController]
class ProductsController
{

    //private ValidatorInterface $validator;

    public function __constructor(): void
    {
        //$this->validator = $validator;
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

    #[Route(path: '/products', name: 'get_products')]
    public function getProducts(ManagerRegistry $entityManager)
    {
        $product = $entityManager->getRepository(Product::class)->findAll();

        echo phpinfo();
    }

    #[Route(path: '/products/create', name: 'create_product')]
    public function createProduct(
        ValidatorInterface $validator,
        ManagerRegistry $doctrine,
        #[MapRequestPayload] \App\ProductApi\Dto\ProductRequestDto $productReview
        ): Response
    {

        $errors = $validator->validate($productReview);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
                return new Response($errorsString);
            }
        $provider = new RequestDtoToProductEntityProvider();
        $product = $provider->provide($productReview);
        $entityManager = $doctrine->getManager();

        // сообщить Doctrine, что вы хотите (в итоге) сохранить Продукт (пока без запросов)
        $entityManager->persist($product);

        // действительно выполнить запросы (например, запрос INSERT)
        $entityManager->flush();

        return new Response('Saved new product with id ' . $product->getId());
    }
}