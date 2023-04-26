<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/panier', name: 'panier')]
class PanierController extends AbstractController
{
    #[Route('/list', name: '_list')]
    public function listAction(EntityManagerInterface $em): Response
    {
        return $this->render('listPanier.html.twig');
    }

    #[Route('/delete/{id}', name: '_delete')]
    public function deleteAction(Produit $id, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $panierRepository = $em->getRepository(Panier::class);
        $panier = $panierRepository->findOneBy(['user' => $user, 'product' => $id]);

        //Quantity dans le panier
        $panierQuantite = $panier->getQuantitePanier();

        // Quantity de base
        $produitQuantite = $id->getQuantite();

        $id->setQuantite($produitQuantite + $panierQuantite);

        $em->remove($panier);
        $em->persist($id);
        $em->flush();
        return $this->redirectToRoute('panier_list');
    }

    #[Route('/add/{id}',name: '_add')]
    public function addAction(Produit $id, EntityManagerInterface $em): Response
    {
        $panierRepository = $em->getRepository();



    }
}
