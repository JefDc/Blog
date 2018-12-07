<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Tag;
use App\Form\ArticleType;
use App\Entity\Category;
use App\Service\Slugify;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="article_list")
     *
     */
    public function index(Request $request)
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_list');
        }

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @param Tag $tag
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("blog/tag/{name}", name="tag")
     */
    public function showByTag(Tag $tag)
    {

        $tags = $tag->getArticles();


        return $this->render("article/tag.html.twig",
            [
                'tags' => $tags
            ]
        );

    }

    /**
     * @param Request $request
     * @param Slugify $slugify
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("article/add", name="article_add")
     */
    public function add(Slugify $slugify, Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid())
        {
            $slug = $slugify->generate($article->getTitle());
            $article->setSlug($slug);
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_list');
        }

        return $this->render('article/add.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/article/{id}", name="article_show")
     * Param $article
     */
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @param Request $request
     * @param Article $article
     * @param Slugify $slugify
     * @return Response
     * @Route("/article/{id}/edit", name="article_edit", methods="GET|POST")
     */
    public function edit(Request $request, Article $article, Slugify $slugify): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $slug = $slugify->generate($article->getTitle());
            $article->setSlug($slug);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_list', [
                'id' => $article->getId()
            ]);

        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' =>$form->createView(),
        ]);

    }

    /**
     * @param Request $request
     * @param Article $article
     * @return Response
     * @Route("/article/{id}/delete", name="article_delete")
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete', $article->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
        }

        return $this->redirectToRoute('article_list');
    }

}
