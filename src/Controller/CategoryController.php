<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index(Request $request)
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        $form = new Category();
        $form = $this->createForm(CategoryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $addCategory = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($addCategory);
            $em->flush();

            return $this->redirectToRoute('category');
        }

        return $this->render('category/index.html.twig', [

            'form' => $form->createView(),
            'categories' => $categories,
        ]);
    }

}
