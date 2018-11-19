<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index()
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }
    /**
     * @Route("/category", name="category")
     */
    public function showCategory($id)
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);
        $categoryName = $articles->getCategory()->getname();
        $this->render('category/index.html.twig', [
            'articles' => $categoryName,
        ]);
    }


}
