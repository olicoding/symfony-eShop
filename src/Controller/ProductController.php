<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/products', name: 'product_list')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
    
        return $this->render('products/list.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/products/create', name: 'product_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->entityManager;
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', 'Product created successfully.');

            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }

        return $this->render('forms/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/products/{id}', name: 'product_show', requirements: ['id' => '\d+'])]
    public function show(Product $product): Response
    {
        return $this->render('products/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/products/{id}/edit', name: 'product_edit', requirements: ['id' => '\d+'])]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->entityManager;
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', 'Product updated successfully.');

            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }

        return $this->render('forms/edit.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
        ]);
    }

    #[Route('/products/{id}/delete', name: 'product_delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        $submittedToken = $request->request->get('_token');
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $submittedToken)) {
            $entityManager->remove($product);
            $entityManager->flush();
    
            $this->addFlash('success', 'Product deleted successfully.');
        }
    
        return $this->redirectToRoute('product_list');
    }
}
