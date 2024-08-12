<?php

namespace App\Controller;

use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

#[AsController]
class ProductsController
{
    #[Route(path: '/test-products', name: 'test_products')]
    public function test()
    {
        try {
            $host = 'empty-symfony-database-1';
            $port = 5432;
            $dbname = 'app';
            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
            $username = 'app';
            $passwd = '!ChangeMe!';
            $dbconn = new \PDO($dsn, $username, $passwd);
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br />";
        }
        // Выполним тестовый SQL запрос
        try {
            $sql = 'Select * FROM pg_database';
            echo '<pre>';

            foreach ($dbconn->query($sql) as $row) {
                print_r($row);
            }
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br />";
        }
    }

    #[Route(path: '/products', name: 'get_products')]
    public function getProducts()
    {
        echo phpinfo();
    }

    #[Route(path: '/create-products', name: 'create_product')]
    public function createProduct(ManagerRegistry $doctrine): Response
    {
  /*      $entityManager = $doctrine->getManager();

        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(1000);
        $product->setCode('black_keyboard');
        $product->setColour('black');

        // сообщить Doctrine, что вы хотите (в итоге) сохранить Продукт (пока без запросов)
        $entityManager->persist($product);

        // действительно выполнить запросы (например, запрос INSERT)
        $entityManager->flush();

        return new Response('Saved new product with id ' . $product->getId());*/
    }
}