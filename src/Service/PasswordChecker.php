<?php

namespace App\Service;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordChecker
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function isStrongPassword(string $password): bool
    {
        // Vérifie que le mot de passe a une longueur d'au moins 6 caractères
        if (strlen($password) < 6) {
            return false;
        }

        // Vérifie que le mot de passe ne fait pas partie des mots de passe faibles
        $weakPasswords = ['azerty', 'qwerty', '123456'];
        foreach ($weakPasswords as $weakPassword) {
            if (password_verify($weakPassword, $password)) {
                return false;
            }
        }

        return true;
    }
}