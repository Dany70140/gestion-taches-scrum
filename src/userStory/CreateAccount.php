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
        //Si tel n'est pas le cas, lancer une exception
        //Vérifier si l'email est valide
        //Si tel n'est pas le cas, lancer un exception
        //Vérifier si le pseudo est entre 2 et 50 caractère
        //Si tel n'est pas le cas, lancer un exception
        //Vérifier si le mot de passe est sécurisé
        //Si tel n'est pas le cas, lancer un exception
        //Vérifier si l'unicité de l'email

        //Insérer les données dans la base de données
        //1. Hash le mot de passe



        //2. Créer une instance de la classe User

        $user = new User(); //setters

        //3. Persist l'instance en utilisant l'entityManager

        $this->entityManager->flush();

        // Envoi du mail de confirmation
        echo "Un email de confirmation  été envoyé à l'utilisateur";
        return $user;
    }
}