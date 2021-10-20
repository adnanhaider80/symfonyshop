<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    /**
     * @Route("/shop", name="shop")
     */
    public function index(): Response
    {
        $data = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('shop/index.html.twig', [
            'products' => $data
        ]);
    }
}
