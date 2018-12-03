<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ArticleSearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormView;

class BlogController extends AbstractController
{


    /**
     * Show all row from article's entity
     *
     * @Route("/", name="blog_index")
     * @return Response A response instance
     */
    public function index(Request $request): Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }
//
//        $form = $this->createForm(ArticleSearchType::class);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted()) {
//            $data = $form->getData();
//        }
        return $this->render(
            'blog/index.html.twig',
            [
                'articles' => $articles,
            ]
        );
    }

//

//    /**
//     * Getting a category whith a formatted slug for title
//     *
//     * @Route("/category/{category}", name="blog_show_category" ).
//     * @param string $category
//     * @return Response A response instance
//     */
//    public function showByCategory(string $category) : Response
//    {
//        if (!$category) {
//            throw $this
//                ->createNotFoundException('No slog has been sent to fing an article in category\'s table.');
//        }
//
//        $category = preg_replace(
//            '/-/',
//            ' ', ucwords(trim(strip_tags($category)), "-")
//        );
//
//        $category = $this->getDoctrine()
//            ->getRepository(Category::class)
//            ->findOneByName($category);
//
//        $article = $this->getDoctrine()
//            ->getRepository(Article::class)
//            ->findBy(array('category' => $category), array('id' => 'asc'), 3);
//
//        if (!$category) {
//            throw $this->createNotFoundException(
//                'No category whit ' . $category . 'name, found in category\'s table.'
//            );
//        }
//
//        return $this->render(
//            'blog/category.html.twig',
//            [
//                'category' => $category,
//                'articles' => $article
//            ]
//        );
//    }

    /**
     *
     * @param Category $category
     * @Route("/category/{name}/all", name="Blog_show_all_category" ).
     * @return Response A response instance
     *
     */
    public function showAllByCategory(Category $category) : Response
    {
        $categories = $category->getArticles();

        return $this->render(
            'blog/categoryAll.html.twig',
        [
            'categories' => $categories
        ]
        );
    }

}