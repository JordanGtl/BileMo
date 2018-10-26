<?php

namespace App\Controller;

use App\Entity\Product;
use App\Exception\ProductNotFoundException;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index()
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    /**
     * @Route("/api/products/{id}", name="product")
     */
    public function productcheck($id, ProductRepository $productRepository)
    {
       $product = $productRepository->find($id);

       if($product == null)
       {
           $data['@context'] = "/contexts/Error";
           $data['@type'] = "Error";
           $data['hydra:title'] = "An error occurred";
           $data['hydra:description'] = "The product $id does not exist";
           return $this->json($data, 404);
       }

       return $this->json($product);
    }
}
