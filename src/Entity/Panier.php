<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name:"i23_paniers")]
#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'panier')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $utilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'panier')]
    private ?Produit $produit = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantitePanier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantitePanier(): ?int
    {
        return $this->quantitePanier;
    }

    public function setQuantitePanier(int $quantitePanier): self
    {
        $this->quantitePanier = $quantitePanier;

        return $this;
    }

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }
}
