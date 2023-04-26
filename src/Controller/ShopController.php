<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/shop', name: 'shop')]
class ShopController extends AbstractController
{
    #[Route('/list', name: '_list')]
    public function listAction(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $produitsRepository = $em->getRepository(Produit::class);
        $produits = $produitsRepository->findAll();

        $args = array(
            'produits' => $produits
        );

        return $this->render('Shop/list.html.twig', $args);
    }

    #[Route('/add', name: '_add')]
    public function addAction(EntityManagerInterface $em, Request $request): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->add('Envoyer', SubmitType::class, ['label' => 'Ajouter un produit']);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($produit);
            $em->flush();
            $this->addFlash('info', 'Produit créé !');
            return $this->redirectToRoute("shop_list");
        }

        $args = array('myform' => $form->createView());
        return $this->render('Shop/add.html.twig', $args);

    }
}
