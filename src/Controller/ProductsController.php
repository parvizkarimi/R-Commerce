<?php

namespace App\Controller;

use App\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produits', name: 'app_products_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('products/index.html.twig', [
            'controller_name' => 'ProductsController',
        ]);
    }

    #[Route('/{slug}', name: 'details')]
    public function details(?Products $product): Response
    {
      if (!$product) {
        return $this->redirectToRoute('app_main');
      }
        return $this->render('products/details.html.twig', [
          'product'=>$product
        ]);
    }
}
