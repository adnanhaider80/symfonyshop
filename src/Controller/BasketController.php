<?php
// src/Controller/BasketController.php
namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BasketController extends AbstractController
{
    /**
    * @Route("/")
    */
    public function number(): Response
    {
        // $number = random_int(0, 100);
        $data = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('basket/show.html.twig', [
            'products' => $data
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function product(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            $this->addFlash('notice','Saved Sucessfully!');

            return $this->redirect("/");
        }

        return $this->render('basket/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function update(Request $request, $id)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            $this->addFlash('notice','Updated Sucessfully!');

            return $this->redirectToRoute("update",['id'=>$id]);
        }

        return $this->render('basket/update.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */

    public function delete(Request $request, $id)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();
        $this->addFlash('notice', 'Deleted Sucessfully!');

        return $this->redirect("/");
    }
}