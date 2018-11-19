<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends AbstractController
{


    /**
     * Show all row from article's entity
     *
     * @Route("/", name="blog_index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }

        return $this->render(
            'blog/index.html.twig',
            ['articles' => $articles]
        );
    }

    /**
     * Getting a article with a formatted slug for title
     *
     * @param string $slug The slugger
     *
     * @Route("/{slug<^[a-z0-9-]+$>}",
     *     defaults={"slug" = null},
     *     name="blog_show")
     * @return Response A response instance
     */
    public function show($slug): Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article with ' . $slug . ' title, found in article\'s table.'
            );
        }

        return $this->render(
            'blog/show.html.twig',
            [
                'article' => $article,
                'slug' => $slug,
            ]
        );
    }

    /**
     * Getting a category whith a formatted slug for title
     *
     * @Route("/category/{category}", name="blog_show_category" ).
     * @param string $category
     * @return Response A response instance
     */
    public function showByCategory(string $category) : Response
    {
        if (!$category) {
            throw $this
                ->createNotFoundException('No slog has been sent to fing an article in category\'s table.');
        }

        $category = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($category)), "-")
        );

        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneByName($category);

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findBy(array('category' => $category), array('id' => 'asc'), 3);

        if (!$category) {
            throw $this->createNotFoundException(
                'No category whit ' . $category . 'name, found in category\'s table.'
            );
        }

        return $this->render(
            'blog/category.html.twig',
            [
                'category' => $category,
                'articles' => $article,
            ]
        );
    }
}