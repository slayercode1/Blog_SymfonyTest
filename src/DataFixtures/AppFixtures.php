<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Driver\IBMDB2\Exception\Factory;
use Doctrine\Persistence\ObjectManager;
use Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hash;
    public function __construct( UserPasswordHasherInterface $hash)
    {
        $this->passwhash = $hash;


    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail("test@test.fr");
        $user->setCreateAt(new \DateTime());
        $user->setPseudo("Dev");
        $hash = $this->passwhash->hashPassword($user, "123456");
        $user->setPassword($hash);
        $manager->persist($user);

        $user2 = new User();
        $user2->setEmail("Dev@test.fr");
        $user2->setCreateAt(new \DateTime());
        $user2->setPseudo("Dev2");
        $hash = $this->passwhash->hashPassword($user, "123456");
        $user2->setPassword($hash);
        $manager->persist($user2);


        for($i=0; $i <2; $i++){

            $cat = new Categorie();
            $cat->setName("Nouvelles technologies n°" .$i);
            $manager->persist($cat);

            for($j=0; $j<5; $j++){

                $article = new Article();
                $article->setTitle("New article n°" .$i);
                $article->setContenu("Lorem Controller" .$j);
                $article->setDatePublication(new \DateTime());
                $article->setImageSrc("image.jpg");
                $article->setNombreVues(0);
                $article->setCateorie($cat);
                $article->setUser($user);
                $manager->persist($article);

                for($k=0; $k<3; $k++){

                    $commentaire = new Commentaire();
                    $commentaire->setDate(new \DateTime());
                    $commentaire->setContenu("le contenue est super cool" .$k);
                    $commentaire->setPublie(false);
                    $commentaire->setArticle($article);
                    $commentaire->setUser($user2);
                    $manager->persist($commentaire);
                }
            }
        }
        $manager->flush();
    }
}
