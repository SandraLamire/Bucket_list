<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wish', name: 'wish_')]
class WishController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function list(WishRepository $wishRepository): Response
    {
        // Récupérer la liste et l'afficher
        $wishes = $wishRepository->findBy(
            ['isPublished'=>true],
            ['dateCreated'=>'DESC']);
        return $this->render('/wish/list.html.twig',['wishes'=>$wishes]);
    }

    #[Route('/{id}', name: 'showDetail', requirements: ['id' => '\d+'])]
    public function showDetail(int $id, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($id);
        if(!$wish){
            throw $this->createNotFoundException('Oups, wish non trouvé !');
        }
        dump($id);
        // Récupération des infos de la série
        return $this->render('wish/detail.html.twig',['wish'=>$wish]);
    }

    public function add(wishRepository $wishRepository,
                        EntityManagerInterface $manager): Response
    {
        $wish = new Wish();

        // TODO Créer un formulaire d'ajout de série
        return $this->render('wish/add.html.twig');

    }

}
