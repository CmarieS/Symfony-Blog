<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        
        for($i = 1;$i <=3 ; $i++)
        {
            $category = new Category();
            $category->setTitle($faker->sentence())
                     ->setDescription($faker->paragraph());

            $manager->persist($category);
            for($j = 1;$j <= mt_rand(4,6) ; $j++)
            {
                $article = new Article;

                $article->setTitle($faker->sentence())
                        ->setContent("Lorem Contenu")
                        ->setContentMore("Lorem Contenu Supplémentaire")
                        ->setImage("http://placehold.it/350x150")
                        ->setCreatedAt($faker->dateTimeBetween('- 6 months'))
                        ->setCategory($category);
    
                $manager->persist($article);
                for($k=1; $k <= mt_rand(4,10);$k++)
                {
                    $now = new \DateTime();
                    $interval = $now->diff($article->getCreatedAt());
                    $days = $interval->days;
                    $minimum = '-' . $days . ' days';

                    $comment = new Comment();
                    $comment->setAuthor($faker->name)
                            ->setContent('Lorem Comment')
                            ->setCreatedAt($faker->dateTimeBetween($minimum))
                            ->setArticle($article); 

                    $manager->persist($comment);
                    
                }
            }
        }

        $manager->flush();
    }
}
