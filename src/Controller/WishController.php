<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use App\Utils\Censurator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wish', name: 'wish_')]
class WishController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function list(WishRepository $wishRepository): Response
    {
        // Récupérer la liste et l'afficher
        $wishes = $wishRepository->findByPublishedWishes();
        return $this->render('/wish/list.html.twig', ['wishes' => $wishes]);
    }

    #[Route('/{id}', name: 'showDetail', requirements: ['id' => '\d+'])]
    public function showDetail(int $id, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($id);
        if (!$wish) {
            throw $this->createNotFoundException('Oups, wish non trouvé !');
        }
        // Récupération des infos de la série
        return $this->render('wish/detail.html.twig', ['wish' => $wish]);
    }

    #[Route('/add', name: 'add')]
    public function add(wishRepository $wishRepository, Request $request, Censurator $censurator): Response
    {

        // données récupérées du formulaire
        $wish = new Wish();
        // setter par défaut author=user
        $wish->setAuthor($this->getUser()->getUserIdentifier());
        $wishForm = $this->createForm(WishType::class, $wish);
        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()) {

            // fonction purify() : utilisation du service pour purifier les infos
            $wish->setTitle($censurator->purify($wish->getTitle()));
            $wish->setDescription($censurator->purify($wish->getDescription()));

            $wishRepository->save($wish, true);
            $this->addFlash('success', 'wish added !');
            return $this->redirectToRoute('wish_showDetail', ['id' => $wish->getId()]);
        }

        // Créer un formulaire d'ajout de série
        return $this->render('wish/add.html.twig', [
            'wishForm' => $wishForm->createView()
        ]);

    }

    #[Route('/update/{id}', name: 'update', requirements: ['id' => '\d+'])]
    public function update(int $id, wishRepository $wishRepository, Request $request, Censurator $censurator): Response
    {
        $wish = $wishRepository->find($id);

        if (!$wish) {
            throw $this->createNotFoundException("Oops Wish not found !");
        }
        $wishForm = $this->createForm(WishType::class, $wish);
        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()) {

        // fonction purify() : utilisation du service pour purifier les infos
        $wish->setTitle($censurator->purify($wish->getTitle()));
        $wish->setDescription($censurator->purify($wish->getDescription()));

        $wishRepository->save($wish, true);
        $this->addFlash('success', 'wish updated !');

        return $this->redirectToRoute('wish_showDetail', ['id' => $wish->getId()]);

        }

        return $this->render('/wish/update.html.twig', [
            'wish' => $wish,
            'wishUpdateForm' => $wishForm->createView()
        ]);
    }

    #[Route('/remove/{id}', name: 'remove')]
    // injection de $serieRepository pour avoir accès à sa méthode remove
    public function remove(int $id, WishRepository $wishRepository)
    {
        // récupérer le souhait grâce à son id
        $wish = $wishRepository->find($id);

        // le supprimer s'il existe
        if ($wish) {
            // true pour flusher
            $wishRepository->remove($wish, true);
            $this->addFlash('warning', 'Wish deleted !');
        } else {
            // sinon exception
            throw $this->createNotFoundException("This wish can't be deleted !");
        }
        // rediriger vers page d'accueil
        return $this->redirectToRoute('wish_list');
    }

}
