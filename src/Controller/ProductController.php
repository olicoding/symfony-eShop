<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'products_list')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
    
        return $this->render('products/list.html.twig', [
            'products' => $products,
        ]);
    }
}

// methods and syntax when querying the database
// $repository = $this->getDoctrine()->getRepository(Product::class);

// // Find all products
// $products = $repository->findAll();

// // Find product by ID
// $product = $repository->find($id);

// // Query for products
// $products = $repository->findBy(['category' => 'Electronics']);