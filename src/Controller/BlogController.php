<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController

{
    /**
     * @Route("/blog/{slug}", name="blog_show", requirements={"slug"="[a-z0-9-]+"})
     */
    public function show($slug='article sans titre')
    {
        $slug2 = str_replace("-"," ",$slug);
        $slug3 = ucwords($slug2);
        return $this->render('blog/index.html.twig', ['slug' => $slug3]);
    }
}
