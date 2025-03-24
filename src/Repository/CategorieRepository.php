<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Référentiel pour la gestion des entités Categorie.
 * 
 * Ce référentiel fournit des méthodes pour interagir avec l'entité Categorie,
 * y compris des requêtes personnalisées pour récupérer les catégories associées aux formations d'une playlist.
 * 
 * @extends ServiceEntityRepository<Categorie>
 */
class CategorieRepository extends ServiceEntityRepository
{
    /**
     * Constructeur du CategorieRepository.
     *
     * @param ManagerRegistry $registry Le registre des gestionnaires pour Doctrine.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    /**
     * Ajoute une catégorie dans la base de données.
     *
     * @param Categorie $entity La catégorie à ajouter.
     */
    public function add(Categorie $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * Supprime une catégorie de la base de données.
     *
     * @param Categorie $entity La catégorie à supprimer.
     */
    public function remove(Categorie $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * Retourne la liste des catégories des formations d'une playlist.
     *
     * Cette méthode permet de récupérer toutes les catégories associées aux formations
     * d'une playlist spécifique, triées par nom.
     *
     * @param int $idPlaylist L'identifiant de la playlist.
     *
     * @return Categorie[] Retourne un tableau d'objets Categorie associés à la playlist.
     */
    public function findAllForOnePlaylist(int $idPlaylist): array
    {
        return $this->createQueryBuilder('c')
            ->join('c.formations', 'f')
            ->join('f.playlist', 'p')
            ->where('p.id = :id')
            ->setParameter('id', $idPlaylist)
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}