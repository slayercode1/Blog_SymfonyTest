<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Entity\User;
use App\Form\CommentaireType;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(ArticleRepository $articles): Response
    {
        $article = $articles->findAll();
        
        return $this->render('accueil/index.html.twig', [
            'articles' => $article,
        ]);
    }

    #[Route('/articles/{id}', name: 'app_articleId')]
    public function indexbyid(ArticleRepository $articles , 
    Article $id,
    Request $request,
    UserRepository $user,
    EntityManagerInterface $manager,
    ): Response
    {
        $article = $articles->findOneBy(["id" => $id]);

        if (!$article) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $comments = $this->createForm(CommentaireType::class);
        $comments->handleRequest($request);

        if( $comments->isSubmitted() && $comments->isValid()){

            $comment= $comments->getData();
            $comment->setDate(new \DateTime());
            $comment->setPublie(true);
            $comment->setArticle($article);

            $users = $this->getUser();
            $comment->setUser($users);

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('app_articleId', ['id' => $article->getId()]);
        
        }

        return $this->render('readMore/index.html.twig', [
            'articlesid' => $article,
            'form' => $comments->createView(),
        ]);
    }
}
