<?php
/**
 * Created by PhpStorm.
 * User: jefdc
 * Date: 2018-11-27
 * Time: 18:04
 */

namespace App\DataFixtures;

use App\Entity\Article;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;


class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        for ($i=0; $i < 50; $i++) {
            $article = new Article();
            $slugify = new Slugify();
            $article->setTitle(mb_strtolower($faker->sentence()));
            $article->setContent($faker->text(200));
            $article->setCategory($this->getReference('categorie_' . rand(0, 4)));

            $slug = $slugify->generate($article->getTitle());
            $article->setSlug($slug);

            $manager->persist($article);
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}


