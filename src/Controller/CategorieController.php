<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(CategorieRepository $categorie): Response
    {
        $categorie = $categorie->findAll();
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorie,
        ]);
    }

    #[Route('/categorie/{id}', name: 'app_categorieArticle')]
    public function categorieArticle(CategorieRepository $categorie, 
    Categorie $id,): Response
    {
        $cate = $categorie->findOneBy(["id" => $id]);
    
        return $this->render('categorie/categorieArticle.html.twig', [
            'cateArticle' => $cate
        ]);
    }
}



