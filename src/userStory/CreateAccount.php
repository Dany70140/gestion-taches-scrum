<?php

namespace App\userStory;

use App\Entity\User;
use Doctrine\ORM\EntityManager;

class CreateAccount
{
    private EntityManager $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        //EUUUuuh l'entityManager est injecté par dépendance
        $this->entityManager = $entityManager;
    }

    //Cette méthode permettra d'executer la user story
    public function execute(string $pseudo, string $email, string $password) : User
    {

        //Vérifier que les données sont présentes

        if (empty($pseudo) || empty($email) || empty($password)) {
            throw new \InvalidArgumentException("Tous les champs sont obligatoires !"); }


        //Si tel n'est pas le cas, lancer une exception
        //Vérifier si l'email est valide

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("L'adresse email n'est pas valide."); }

        //Si tel n'est pas le cas, lancer un exception
        //Vérifier si le pseudo est entre 2 et 50 caractère

        if (strlen($pseudo) < 2 || strlen($pseudo) > 50) {
            throw new \InvalidArgumentException("Le pseudo doit contenir entre 2 et 50 caractères."); }

        //Si tel n'est pas le cas, lancer un exception
        //Vérifier si le mot de passe est sécurisé

        if (strlen($password) < 8 ||
            !hasUppercase($password) ||
            !hasLowercase($password) ||
            !hasDigit($password) ||
            !hasSpecialChar($password)) {
            throw new \InvalidArgumentException("Le mot de passe doit contenir au moins 8 caractères, avec une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.");
        }

        function hasUppercase($str) {
            foreach (str_split($str) as $char) {
                if (ctype_upper($char)) {
                    return true;
                }
            }
            return false;
        }

        function hasLowercase($str) {
            foreach (str_split($str) as $char) {
                if (ctype_lower($char)) {
                    return true;
                }
            }
            return false;
        }

        function hasDigit($str) {
            foreach (str_split($str) as $char) {
                if (ctype_digit($char)) {
                    return true;
                }
            }
            return false;
        }

        function hasSpecialChar($str) {
            foreach (str_split($str) as $char) {
                if (!ctype_alnum($char)) {
                    return true;
                }
            }
            return false;
        }


        //Si tel n'est pas le cas, lancer un exception
        //Vérifier si l'unicité de l'email

        $exist = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        if ($exist !== null) {
            throw new \InvalidArgumentException("L'email entré existe déjà.");}

        //Insérer les données dans la base de données
        //1. Hash le mot de passe

        $hashedPassword = password_hash($password, PASSWORD_ARGON2I);

        //2. Créer une instance de la classe User

        $user = new User(); //setters

        //3. Persist l'instance en utilisant l'entityManager

        $this->entityManager->flush();

        // Envoi du mail de confirmation
        echo "Un email de confirmation  été envoyé à l'utilisateur";
        return $user;
    }
}