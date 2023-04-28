<?php

namespace App\DataFixtures;

use App\Entity\Panier;
use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordEncoder = $passwordHasher;
    }

    public function load(ObjectManager $em): void
    {


        $user1 = new User();
        $user1 ->setLogin("sadmin")
            ->setNom("Jean")
            ->setBirthday( new \DateTimeImmutable("02-04-1950"))
            ->setRoles(["ROLE_SUPER_ADMIN"])
            ->setPrenom("Albert");
        $hashedPassword = $this->passwordEncoder->hashPassword($user1, 'nimdas');
        $user1->setPassword($hashedPassword);

        $em->persist($user1);

        $panier0 = new Panier();
        $panier0->setQuantitePanier(2);
        $em->persist($panier0);

        $user2 = new User();
        $user2 ->setLogin("gilles")
            ->setNom("Subrenat")
            ->setBirthday(new \DateTimeImmutable("05-06-1958"))
            ->setRoles(["ROLE_ADMIN"])
            ->setPrenom("Gilles")
            ->addPanier($panier0);
        $hashedPassword2 = $this->passwordEncoder->hashPassword($user2,'sellig');
        $user2->setPassword($hashedPassword2);

        $em->persist($user2);

        $user3 = new User();
        $user3 ->setLogin("rita")
            ->setNom("Zrour")
            ->setBirthday(new \DateTimeImmutable("07-11-1962"))
            ->setRoles(["ROLE_CLIENT"])
            ->setPrenom("Rita");
        $hashedPassword3 = $this->passwordEncoder->hashPassword($user3,'atir');
        $user3->setPassword($hashedPassword3);

        $em->persist($user3);

        $user4 = new User();
        $user4 ->setLogin("simon")
            ->setNom("Rame")
            ->setBirthday(new \DateTimeImmutable("23-12-1982"))
            ->setRoles(["ROLE_CLIENT"])
            ->setPrenom("Simon");
        $hashedPassword4 = $this->passwordEncoder->hashPassword($user4,'nomis');
        $user4->setPassword($hashedPassword4);

        $em->persist($user4);

        $produit = new Produit();
        $produit
            ->setLibelle("orange")
            ->setQuantite(100)
            ->setPrix(55)
            ->addPanier($panier0);
        $em->persist($produit);

        $em->flush();
    }
}
