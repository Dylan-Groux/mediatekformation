<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * Référentiel pour la gestion des entités User.
 * 
 * Ce référentiel fournit des méthodes pour interagir avec l'entité User,
 * y compris des requêtes personnalisées et la mise à jour des mots de passe.
 * 
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    /**
     * Constructeur du UserRepository.
     *
     * @param ManagerRegistry $registry Le registre des gestionnaires pour Doctrine.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Met à jour (rehash) automatiquement le mot de passe de l'utilisateur au fil du temps.
     *
     * Cette méthode est utilisée pour mettre à jour le mot de passe haché d'un utilisateur lorsque cela est nécessaire.
     * Elle garantit que le mot de passe est stocké de manière sécurisée dans la base de données bien que la logique ne soit
     * pas réaliser ici, elle permet actuellement de mettre un jour le mots de passe.
     *
     * @param PasswordAuthenticatedUserInterface $user L'utilisateur dont le mot de passe doit être mis à jour.
     * @param string $newHashedPassword Le nouveau mot de passe haché à définir pour l'utilisateur.
     *
     * @throws UnsupportedUserException Si l'utilisateur fourni n'est pas une instance de l'entité User.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Les instances de "%s" ne sont pas supportées.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
}