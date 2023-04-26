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
        $user = $this->getUser();
        $panier = $em->getRepository(Panier::class);
        $panierUsers = $panier->findOneBy(['utilisateur' => $user]);

        $args = array(
            'panier' => $panierUsers
        );

        return $this->render('Panier/list.html.twig', $args);
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


    #[Route('/add',name: '_add')]
    public function addAction(EntityManagerInterface $em, Request $request): Response
    {
        $quantite = $request->request->get("quantite");
        $produitId = $request->request->get("produit_id");
        $user = $this->getUser();

        $produitRepository = $em->getRepository(Produit::class);
        $produit = $produitRepository->find($produitId);

        $panier = new Panier();
        $panier->setQuantitePanier(intval($quantite))
            ->setUser($user)
            ->setProduit($produit);

        $userPaniers = $user->getPaniers()->getValues();
        foreach($userPaniers as $userPanier) {
            // Si l'utilisateur à déjà ce produit dans la table panier
            // alors ajouter la nouvelle quantity à celle déjà présente dans la bdd
            if($userPanier->getProduit() === $produit) {
                $panier = $userPanier;
                $panier->setQuantitePanier($panier->getQuantitePanier() + $quantite);
            }
        }

        $em->persist($panier); // Pour le panier c'est bon

        // Supprimer la quantité qui a été ajouté au panier à celle du produit
        $produitQuantite = $produit->getQuantite();
        $produit->setQuantite($produitQuantite - $quantite);
        $em->persist($produit);
        $em->flush();
        return $this->redirectToRoute('panier_list');
    }
}
